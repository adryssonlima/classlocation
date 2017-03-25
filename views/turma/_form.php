<?php

use app\models\Curso;
use app\models\Periodo;
use app\models\Semana;
use app\models\Turma;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Turma */
/* @var $form ActiveForm */
?>

<style>
    .tdhover:hover {
        background-color: #d9d9d9;
    }
</style>

<div class="turma-form">
</div>

<div class="row">
    <section>
    <div class="wizard">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" class="active">
                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Dados da Turma">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-education"></i>
                        </span>
                    </a>
                </li>

                <li role="presentation" class="disabled">
                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Definição de Horário">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </a>
                </li>

                <li role="presentation" class="disabled">
                    <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Resumo das Informações">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-ok"></i>
                        </span>
                    </a>
                </li>

            </ul>
        </div>

        <!--<form role="form"> -->
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <?php $form = ActiveForm::begin(['id' => 'turma-form', 'fieldConfig' => ['options' => ['tag' => false]]]); ?>
                        <div class="step1">
                            <h3>Nova Turma</h3><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'identificador')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'curso')->dropDownList(ArrayHelper::map(Curso::find()->all(), 'id', 'nome'), ['prompt' => 'Selecione...']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'semestre')->dropDownList([], ['prompt'=>'Selecione...']) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'turno')->dropDownList(['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'], ['prompt'=>'Selecione...']) ?>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                    <ul class="list-inline pull-right">
                        <span id="valida"></span>
                        <li><button id="conf-dados-turma" type="button" class="btn btn-primary next-step">Confirmar Dados da Turma <i class="glyphicon glyphicon-arrow-right"></i></button></li>
                    </ul>
                </div>
                <div class="tab-pane" role="tabpanel" id="step2">
                    <div class="step2">
                        <div class="step_21">
                            <div class="row">

                                <?php
                                    $dias_da_semana = ArrayHelper::map(Semana::find()->all(), 'id', 'dia');
                                    $periodos = ArrayHelper::map(Periodo::find()->all(), 'id', 'intervalo');
                                ?>
                                <h3>Quadro de Horários da Turma</h3><br>
                                <ul class="list-inline pull-right">
                                    <li><button id="indisponiveis" type="button" class="btn btn-success">Atualizar Horários Indisponíveis <i class="glyphicon glyphicon-refresh"></i></button></li>
                                </ul>
                                <table id="table-horario" class="table table-bordered table-striped table-hover">
                                  <thead>
                                    <tr>
                                      <th><span class="glyphicon glyphicon-time"></span></th>
                                      <?php foreach ($dias_da_semana as $keyDia => $dia) { ?>
                                          <th><?= $dia ?></th>
                                      <?php }?>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($periodos as $keyPeriodo => $periodo) { ?>
                                          <tr>
                                            <th><?= $periodo ?></th>
                                            <?php foreach ($dias_da_semana as $keyDia => $dia) { ?>
                                                <td class="tdhover">
                                                    <span id="<?= 'span'.$keyDia.$keyPeriodo ?>">

                                                    </span>
                                                    <a id="<?= 'link'.$keyDia.$keyPeriodo ?>" id_dia="<?= $keyDia ?>" id_periodo="<?= $keyPeriodo ?>" href="#" class="pull-right" data-toggle="modal" data-target="#myModal">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </a>
                                                </td>
                                            <?php }?>
                                          </tr>
                                      <?php }?>
                                  </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="step-22">

                        </div>
                    </div>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-default prev-step"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</button></li>
                        <li><button type="button" class="btn btn-primary next-step">Confirmar Horário <i class="glyphicon glyphicon-arrow-right"></i></button></li>
                    </ul>
                </div>

                <div class="tab-pane" role="tabpanel" id="complete">
                    <div class="step44">
                        <h3>Resumo dos Dados</h3><br>


                    </div>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-primary next-step">Finalizar <i class="glyphicon glyphicon-ok"></i></button></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
    <!--    </form> -->
    </div>
</section>
</div>

<!-- INICIO MODAL -->
<?php
    Modal::begin([
        'header' => '<h3><span class="glyphicon glyphicon-edit"></span> Escolha de Sala e Disciplina</h3>',
        'id' => 'myModal',
        'footer' => Html::button('Cancelar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . Html::button('Confirmar', ['class' => 'btn btn-primary modal-confirmar', 'data-dismiss' => 'modal'])
    ]);
?>
    <input type="hidden" id="dia-periodo" />
    <div class="rows">
        <label for="sel1">Sala:</label>
        <select class="form-control" id="modal-sala">

        </select>
    </div>
    <br>
    <div class="rows">
        <label for="dis">Disciplina:</label>
        <select class="form-control" id="modal-disciplina">

        </select>
    </div>
    <br>
    <div class="rows">
        <label for="map">Mapa das Salas:</label>
        <span id="map" class="glyphicon glyphicon-map-marker"></span>
    </div>
<?php
    Modal::end();
?>
<!-- FIM MODAL -->


<script src="js/functions-wizard-circular.js"></script>
<script>

    //valida o formulário
    $("#conf-dados-turma").prop("disabled",true);
    $("#valida").text("*O Preenchimento de todos os campos é obrigatório.").css('color', 'red');
    $('#turma-form').focusout(function() {
        var turma = [
            $('#turma-identificador').val(),
            $('#turma-curso').val(),
            $('#turma-semestre').val(),
            $('#turma-turno').val()
        ];
        if (turma[0] == "" || turma[1] == "" || turma[2] == "" || turma[3] == "") {
            $("#conf-dados-turma").prop("disabled",true);
        } else {
            $("#valida").text("");
            $("#conf-dados-turma").prop("disabled",false);
        }
    });

    //traz os semestres referentes ao curso escolhido
    $('#turma-curso').on('change', function (e) {
        var id_disciplina = $(this).val();
        getSemestres(id_disciplina);
    });

    function getSemestres(value) {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/?r=turma/get-quantidade-semestres' ?>',
            type: 'post',
            data: {
                id: value
            },
            success: function (data) {
                //console.log(data);
                $("#turma-semestre").empty();
                for (i = 1; i <= data; i++) {
                    $("#turma-semestre").append($("<option></option>").attr("value", i).text(i));
                }
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

</script>
