<?php
namespace frontend\controllers;

use Yii;
use common\models\Parser;
use common\models\ParserSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use common\models\Products;
use GuzzleHttp\Client;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale'=>[
                'class'=>'common\actions\SetLocaleAction',
                'locales'=>array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ParserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionParse()
    {


        $a = Products::find()->from('parser_products')->min('id'); // give the min id value
        $b = Products::find()->from('parser_products')->max('id'); // give the max id value
//        $i = $a;
        $model = Parser::find()->all(); //Select values ​​from the db to transfer the old price

//        var_dump($prices);

        Yii::$app->db->createCommand()->truncateTable('parser')->execute(); //clear the table

        for ($i = $a; $i <= $b; $i++) {
            //give the url of product
            $url = (new \yii\db\Query())
                ->select(['url'])
                ->from('parser_products')
                ->where(['id' => $i])
                ->limit(1)
                ->one();
            $url = ArrayHelper::getValue($url, 'url');  //converting array to string
            echo $url . " ";
//
            //give the name of site
            $site = (new \yii\db\Query())
                ->select(['site_id'])
                ->from('parser_products')
                ->where(['id' => $i])
                ->limit(1)
                ->one();
            $site = ArrayHelper::getValue($site, 'site_id');  //converting array to string
            echo $site . " ";

            $name = (new \yii\db\Query())
                ->select(['name'])
                ->from('parser_products')
                ->where(['id' => $i])
                ->limit(1)
                ->one();
            $name = ArrayHelper::getValue($name, 'name');  //converting array to string
            echo $name . " ";

            $sku = (new \yii\db\Query())
                ->select(['sku'])
                ->from('parser_products')
                ->where(['id' => $i])
                ->limit(1)
                ->one();
            $sku = ArrayHelper::getValue($sku, 'sku');  //converting array to string
            echo $sku . " ";


//            $price_new_tag = (new \yii\db\Query())//give the price_new_tag
//            ->select(['price_new_tag'])
//                ->from('parser_sites')
//                ->where(['name' => $site])
//                ->limit(1)
//                ->one();
//            $price_new_tag = ArrayHelper::getValue($price_new_tag, 'price_new_tag');  //converting array to string
////        echo $price_new_tag;


            $price_tag = (new \yii\db\Query())//give the price_tag
            ->select(['price_tag'])
                ->from('parser_sites')
                ->where(['name' => $site])
                ->limit(1)
                ->one();
            $price_tag = ArrayHelper::getValue($price_tag, 'price_tag');  //converting array to string
            $price_tag = $price_tag . ':first';


            $tag_active = (new \yii\db\Query())//give the tag_active
            ->select(['tag_active'])
                ->from('parser_sites')
                ->where(['name' => $site])
                ->limit(1)
                ->one();
            $tag_active = ArrayHelper::getValue($tag_active, 'tag_active');  //converting array to string
            $tag_active = $tag_active . ':first';



            $client = new Client();  //Run Guzzle
            $res = $client->request('GET', $url);

//            $error_code = $res->getStatusCode();
            $body = $res->getBody();
            $document = \phpQuery::newDocumentHTML($body);
            $price = $document->find($price_tag);
            $active = $document->find($tag_active);
            $price = preg_replace("/[^0-9\.\,]/", '', $price); //replace the "a-z"

            $price = trim($price, ".");  //trim the string
//        $active = $document->find($tag_active);
//            $active = 0;
//            if ($document->find($tag_active))
//                $active = 1;
//            $active = ArrayHelper::getValue($active, 'active');
//            print_r($active);
//            die ();
            $active = strval($active); // convert into the string
            $active = strip_tags($active); //strip the html tags

            $active = strval($active);
            $active = strip_tags($active);
//
            echo $active . " ";
//            die();

//            echo $error_code . "<html> <br></html>";
            echo $price . "<html> <br></html>";

//            echo $error_code;
//            $parser = Parser::findOne($i);
//            $parser_price = new ParserPrice();
//            $parser_price->price = $price;
//            $parser_price->save();

            $parser = new Parser(); //save to db
            $parser->price = $price;
            $parser->product_name = $name;
            $parser->site_name = $site;
            $parser->product_sku = $sku;
            $parser->available = $active;

            $parser->save();


//            $price = (new \yii\db\Query())
//                ->select(['url'])
//                ->from('parser_products')
//                ->where(['id' => $i])
//                ->limit(1)
//                ->one();
//            $url = ArrayHelper::getValue($url, 'url');  //converting array to string
//        echo $price;
//        var_dump($ret);
//        echo $document;
//        curl_close($res);
        }
        if($model) {                            //insert old price to db
            foreach ($model as $m) {
                $id = $m->id;
                $price_old = $m->price;

                $model = Parser::findOne($id);
                $model->price_old = $price_old;
                $model->save();

            }
        }
        unset ($model);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    'options'=>['class'=>'alert-success']
                ]);
                return $this->refresh();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>\Yii::t('frontend', 'There was an error sending email.'),
                    'options'=>['class'=>'alert-danger']
                ]);
            }
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }
}
