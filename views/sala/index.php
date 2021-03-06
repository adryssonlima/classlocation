<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salas';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sala-index">

    <div class="row">
        <h1 style="float:left;"><i class="fa fa-location-arrow" aria-hidden="true"></i> <?= Html::encode($this->title) ?></span>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12 painel-titulo">
            <div class="col-md-8">
                <button type="button" class="btn btn-success new"><i class="fa fa-location-arrow" aria-hidden="true"></i> Nova Sala</button>
            </div>
            <div class="col-md-4">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            //'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => "table table-striped"
            ],
            'columns' => [
                [
                  'attribute' => 'identificador',
                  'value' => 'identificador',
                  'enableSorting' => false,
                ],
                [
                  'attribute' => 'tipo',
                  'value' => 'tipo',
                  'enableSorting' => false,
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url) {
                            return "<i title='Visualizar' class='fa fa-eye fa-lg text-success view clicavel' url='" . $url . "' aria-hidden='true'></i>";
                        },
                        'update' => function ($url) {
                            return "<i title='Editar' class='fa fa-pencil-square-o fa-lg color-green text-primary update clicavel' url='" . $url . "' aria-hidden='true'></i>";
                        },
                        'delete' => function ($id) {
                            return "<i title='Remover' class='fa fa-trash-o fa-lg delete text-danger clicavel' url='" . $id . "' aria-hidden='true'></i>";
                        }
                    ]
                ],
            ]
        ]);
        ?>
    </div>
</div>

<?php
Modal::begin([
    "header" => "<h3 class='modal-titulo'></h3>",
    "id" => "modal"
]);
echo "<div class='modal-conteudo'></div>";
Modal::end();
?>

<script>

    $(".new").click(function(){
        var url = "<?= Yii::$app->request->baseUrl . '/sala/create' ?>";
        var titulo = "<i class='fa fa-location-arrow' aria-hidden='true'></i> Nova Sala";
        var csrftoken = "<?= Yii::$app->request->getCsrfToken() ?>";
        modalAjax(url, titulo, csrftoken);
    });

    $(".view").click(function(){
        var url = $(this).attr("url");
        var titulo = "<i class='fa fa-eye aria-hidden='true'></i> Visualizar Sala";
        var csrftoken = "<?= Yii::$app->request->getCsrfToken() ?>";
        modalAjax(url, titulo, csrftoken);
    });

    $(".update").click(function(){
        var url = $(this).attr("url");
        var titulo = "<i class='fa fa-pencil-square-o' aria-hidden='true'></i> Alterar Sala";
        var csrftoken = "<?= Yii::$app->request->getCsrfToken() ?>";
        modalAjax(url, titulo, csrftoken);
    });

    $(".delete").click(function(){
        var url = $(this).attr("url");
        var titulo = "<i class='fa fa-trash-o aria-hidden='true'></i> Remover Sala";
        var csrftoken = "<?= Yii::$app->request->getCsrfToken() ?>";
        modalAjax(url, titulo, csrftoken);
    });

</script>
