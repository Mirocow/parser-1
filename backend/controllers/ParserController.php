<?php

namespace backend\controllers;

use common\models\ParserPrice;
use common\models\Products;
use Yii;
use common\models\Parser;
use common\models\ParserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use GuzzleHttp\Client;
use yii\helpers\Url;
use keltstr\simplehtmldom\SimpleHTMLDom as SHD;
use yii\db\ActiveRecord;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;


/**
 * ParserController implements the CRUD actions for Parser model.
 */
class ParserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Parser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Parser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Parser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Parser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Parser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Parser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Parser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Parser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Parser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionParse()
    {

        Yii::$app->db->createCommand("set @i := -1;
update parser_products set id = (@i := @i+1 ) order by id;")->execute();
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
            $handle = curl_init($url);
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

            /* Get the HTML or whatever is linked in $url. */
            $response = curl_exec($handle);

            /* Check for 404 (file not found). */
            $error_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $error_code = strval($error_code); // convert into the string
            $error_code = strip_tags($error_code); //strip the html tags
//            $error_code = preg_replace("/[^0-9\.\,]/", '', $error_code); //replace the "a-z"
            if($error_code == 404 || $error_code == 302) {
                echo $error_code;
                $parser = new Parser(); //save to db
                $parser->price = '0';
                $parser->product_name = $name;
                $parser->site_name = $site;
                $parser->product_sku = $sku;
                $parser->available = '0';
                $parser->error_code = $error_code;
                $parser->error_text = 'Ошибка URL';
                $parser->save();
                curl_close($handle);
            }else{
                $res = $client->request('GET', $url,[
                        'headers' => [
                            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/60.0.3112.78 Chrome/60.0.3112.78 Safari/537.36',
                            'Accept'     => 'application/json',
                            'X-Foo'      => ['Bar', 'Baz']
                        ]
                    ]
                );

                $error_code = $res->getStatusCode();
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
                $error_code = strval($error_code); // convert into the string
                $error_code = strip_tags($error_code); //strip the html tags

                echo $price . " ";
                echo $error_code . "<html> <br></html>";


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
                $parser->error_code = $error_code;
                $parser->error_text = 'Ok';
                $parser->save();
            }



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
}
