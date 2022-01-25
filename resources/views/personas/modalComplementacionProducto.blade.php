<!-- Modal complementacion de entrega de producto -->
<div class="modal fade" id="modal-complementacion-producto" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="title-modal_con"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" id="name_con" disabled>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Carnet Identidad Nº</label>
                            <input type="text" class="form-control" id="ci_con" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label>Expedido</label>
                            <input type="text" class="form-control" id="expedido_con" disabled>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Nº Celular</label>
                            <input type="text" class="form-control" id="celular_con" disabled>
                        </div>
                        <div class="col-sm-4">
                            <label>Distrito</label>
                            <input type="text" class="form-control" id="distrito_con" disabled>
                        </div>
                        <div class="col-sm-4">
                            <label>Sub Central</label>
                            <input type="text" class="form-control" id="central_con" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Rubro</label>
                            <input type="text" class="form-control" id="rubro_con" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label>Tipo</label>
                            <input type="text" class="form-control" id="tipo_con" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="div-entregados">
                    <div style="text-align: center; color: #f5365c;">
                        <label>Productos ya Entregados</label>
                    </div>
                    <div id="productos-entregados_con">
                    </div>
                </div>

                <div class="form-group" id="s-observacion">
                    <label>Productos</label>
                    <select class="form-control" multiple="multiple" id="productos-select_con">

                    </select>
                </div>

                <div class="form-group" id="txt_obs">
                    <label>Observación</label>
                    <textarea class="form-control" id="observacion_con"
                        placeholder="LLenar este campo solo si es necesario" rows="5"></textarea>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-complementacion-producto">Guardar</button>
            </div>
        </div>
    </div>
</div>