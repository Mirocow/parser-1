<?php

namespace backend\controllers;

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
        Yii::$app->db->createCommand()->truncateTable('parser')->execute(); //clear the table


        //client settings
        $proxy = false;
        $post = false;
        $post_data = false;
        $user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36';
        $headers = false;
        $extradata = false;

        $a = Products::find()->from('parser_products')->min('id'); // give the min id value
        $b = Products::find()->from('parser_products')->max('id'); // give the max id value
//        $i = $a;

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


            $price_new_tag = (new \yii\db\Query())//give the price_new_tag
            ->select(['price_new_tag'])
                ->from('parser_sites')
                ->where(['name' => $site])
                ->limit(1)
                ->one();
            $price_new_tag = ArrayHelper::getValue($price_new_tag, 'price_new_tag');  //converting array to string
//        echo $price_new_tag;


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
//        echo $tag_active;


            $client = new Client();
//        $client = new Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
//            $client->Client()->setDefaultOption('config/curl/' . CURLOPT_SSL_VERIFYPEER, false);
            $res = $client->request('GET', $url);

            $error_code = $res->getStatusCode();
            $body = $res->getBody();
            $document = \phpQuery::newDocumentHTML($body);
            $price = $document->find($price_tag);
            $price = preg_replace("/[^0-9\.\,]/", '', $price);

            $price = trim($price, ".");
//        $active = $document->find($tag_active);
            $active = 0;
            if ($document->find($tag_active))
                $active = 1;

            echo $active . " ";


            echo $price . " ";

//            echo $error_code;
//            $parser = Parser::findOne($i);

            $parser = new Parser();
            $parser->price = $price;
            $parser->product_name = $name;
            $parser->site_name = $site;
            $parser->product_sku = $sku;
//            $parser->error_code = $error_code;
            $parser->available = $active;
            $parser->save();


//        echo $price;
//        var_dump($ret);
//        echo $document;
//        curl_close($res);
        }
    }
}
