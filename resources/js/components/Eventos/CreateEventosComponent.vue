<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 mt-1">{{(!editMode)?'Criar':'Editar'}} Evento</h4>
                    </div>

                    <div class="card-body">
                        <AlertErrors :form="formEventos" message="Houve(ram) erro(s) ao registrar este Evento."></AlertErrors>
                        <AlertSuccess :form="formEventos" message="O Evento foi registrado com sucesso."></AlertSuccess>
                        <div class="col-md-12 form-group">
                            <label for="data_evento">Data do evento: <span class="text-danger">*</span></label>
                            <input type="date" name="data_evento" id="data_evento" class="form-control" v-model="formEventos.data_evento" :class="{'is-invalid' : formEventos.errors.has('data_evento')}" :disabled="editMode && formEventos.convidados.length > 0"/>
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
                            <button type="button" role="button" class="btn btn-danger" :disabled="formEventos.busy" @click.prevent="voltarParaEventos()">Cancelar</button>
                            <button type="button" role="button" class="btn btn-success" :disabled="formEventos.busy" @click.prevent="(!editMode)?salvarEvento():editarEvento()">{{(!editMode)?'Salvar':'Editar'}}</button>
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
                convidados: '',
                created_at: '',
                updated_at: '',
            }),
            editMode: false,
        }),
        props: {
            id: {
                required: false
            }
        },
        mounted() {

            // Vamos preencher a data para que já venha com o dia de hoje...
            let data_atual = moment(new Date()).format('YYYY-MM-DD');
            this.formEventos.data_evento = data_atual;
            if(typeof this.$props.id != 'undefined'){
                axios.get('/api/eventos/'+this.$props.id)
                .then((response) => {
                    if(response.data != {}){
                        this.formEventos.fill(response.data);
                        this.editMode = true;
                    }else{
                        this.$toastr.e("Não foi possível recuperar este evento. Tens certeza de que ele existe?");
                    }
                })
            }
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
                            this.voltarParaEventos();
                        })
                        .catch((error) => {
                            Swal.close();
                            this.$Progress.fail();
                            this.$toastr.e("Evento não pode ser salvo. Algo aconteceu...");
                        })
                    }
                });
            },
            editarEvento(){
                Confirme.fire({
                    title: 'Editar?',
                    text: 'Tens certeza que desejas editar este Evento?',
                })
                .then((response) => {
                    if(response.value){
                        this.$Progress.start();
                        Carregando.fire({
                            title: 'Aguarde...',
                            text: 'Estamos tentando editar o evento.',
                        });
                        this.formEventos.put('/api/eventos/'+this.formEventos.id)
                        .then((res) => {
                            this.formEventos.fill(res.data);
                            Swal.close();
                            this.$Progress.finish();
                            this.$toastr.s("Evento salvo com sucesso.");
                            this.voltarParaEventos();
                        })
                        .catch((error) => {
                            Swal.close();
                            this.$Progress.fail();
                            this.$toastr.e("Evento não pode ser salvo. Algo aconteceu...");
                        })
                    }
                });
            },
            voltarParaEventos(){
                this.$router.push('/eventos');
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
