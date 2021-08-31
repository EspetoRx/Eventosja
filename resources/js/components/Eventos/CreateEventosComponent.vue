<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 mt-1">Criar evento</h4>
                    </div>

                    <div class="card-body">
                        <AlertErrors :form="formEventos" message="Houve(ram) erro(s) ao registrar este Evento."></AlertErrors>
                        <AlertSuccess :form="formEventos" message="O Evento foi registrado com sucesso."></AlertSuccess>
                        <div class="col-md-12 form-group">
                            <label for="data_evento">Data do evento: <span class="text-danger">*</span></label>
                            <input type="date" name="data_evento" id="data_evento" class="form-control" v-model="formEventos.data_evento" :class="{'is-invalid' : formEventos.errors.has('data_evento')}" />
                            <HasError :form="formEventos" field="data_evento"></HasError>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="descricao">Descrição do evento: <span class="text-danger">*</span></label>
                            <textarea name="descricao" id="descricao" cols="30" rows="5" class="form-control" :class="{'is-invalid' : formEventos.errors.has('descricao')}" v-model="formEventos.descricao" placeholder="Descreva aqui o seu EventoJá!"></textarea>
                            <HasError :form="formEventos" field="descricao"></HasError>
                        </div>
                        <div class="col-md-12 form-group text-danger">
                            * Preenchimento obrigatório.
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <button type="button" role="button" class="btn btn-danger" :disabled="formEventos.busy">Cancelar</button>
                            <button type="button" role="button" class="btn btn-success" :disabled="formEventos.busy" @click.prevent="salvarEvento()">Salvar</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from 'vform';
    import {HasError, AlertError, AlertSuccess, AlertErrors} from 'vform/src/components/bootstrap4';
    import moment from 'moment';
    export default {
        data: () => ({
            formEventos: new Form({
                id: '',
                data_evento: '',
                descricao: '',
                created_at: '',
                updated_at: '',
            }),
        }),
        mounted() {

            // Vamos preencher a data para que já venha com o dia de hoje...
            let data_atual = moment(new Date()).format('YYYY-MM-DD');
            this.formEventos.data_evento = data_atual;
        },
        methods: {
            salvarEvento(){
                Confirme.fire({
                    title: 'Salvar?',
                    text: 'Tens certeza que desejas salvar este Evento?',
                })
                .then((response) => {
                    if(response.value){
                        this.$Progress.start();
                        Carregando.fire({
                            title: 'Aguarde...',
                            text: 'Estamos tentando salvar o evento.',
                        });
                        this.formEventos.post('/api/eventos')
                        .then((res) => {
                            this.formEventos.fill(res.data);
                            Swal.close();
                            this.$Progress.finish();
                            this.$toastr.s("Evento salvo com sucesso.");
                        })
                        .catch((error) => {
                            Swal.close();
                            this.$Progress.fail();
                            this.$toastr.e("Evento não pode ser salvo. Algo aconteceu...");
                        })
                    }
                })
            }
        },
        components: {
            HasError,
            AlertError,
            AlertErrors,
            AlertSuccess
        }
    }
</script>
