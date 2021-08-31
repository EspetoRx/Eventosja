<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 mt-1">{{(!editMode)?'Criar':'Editar'}} Convidado</h4>
                    </div>

                    <div class="card-body">
                        <AlertErrors :form="formConvidados" message="Houve(ram) erro(s) ao cadastrar o Convidado."></AlertErrors>
                        <AlertSuccess :form="formConvidados" message="O Convidado foi cadastrado com sucesso."></AlertSuccess>
                        <div class="col-md-12 form-group">
                            <label for="nome">Nome: <span class="text-danger">*</span></label>
                            <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome do convidado" v-model="formConvidados.nome" :class="{'is-invalid' : formConvidados.errors.has('nome')}">
                            <HasError :form="formConvidados" field="nome"></HasError>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="email">E-mail: <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="emal@company.com" v-model="formConvidados.email" :class="{'is-invalid' : formConvidados.errors.has('email')}" :disabled="editMode">
                            <HasError :form="formConvidados" field="email"></HasError>
                        </div>
                        <div class="col-md-12 form-group text-danger">
                            * Preencimento obrigatório.
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-danger" type="button" role="button" :disabled="formConvidados.busy" @click.prevent="voltaParaConvidados()">Cancelar</button>
                            <button class="btn btn-success" type="button" role="button" @click.prevent="(!editMode)?salvarConvidado():editarConvidado()" :disabled="formConvidados.busy">{{(!editMode)?'Salvar':'Editar'}}</button>
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
            formConvidados: new Form({
                id: '',
                nome: '',
                email: '',
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
        methods: {
            salvarConvidado(){
                Confirme.fire({
                    title: 'Salvar?',
                    text: 'Tens certeza que desejas salvar este Convidado?',
                })
                .then((response) => {
                    if(response.value){
                        this.$Progress.start();
                        Carregando.fire({
                            title: 'Aguarde...',
                            text: 'Estamos tentando salvar o convidado.',
                        });
                        this.formConvidados.post('/api/convidados')
                        .then((res) => {
                            this.formConvidados.fill(res.data);
                            Swal.close();
                            this.$Progress.finish();
                            this.$toastr.s("Convidado salvo com sucesso.");
                            this.voltaParaConvidados();
                        })
                        .catch((error) => {
                            Swal.close();
                            this.$Progress.fail();
                            this.$toastr.e("Convidado não pode ser salvo. Algo aconteceu...");
                        })
                    }
                });
            },
            editarConvidado(){
                Confirme.fire({
                    title: 'Editar?',
                    text: 'Tens certeza que desejas editar este Convidado?',
                })
                .then((response) => {
                    if(response.value){
                        this.$Progress.start();
                        Carregando.fire({
                            title: 'Aguarde...',
                            text: 'Estamos tentando editar o convidado.',
                        });
                        this.formConvidados.put('/api/convidados/'+this.formConvidados.id)
                        .then((res) => {
                            this.formConvidados.fill(res.data);
                            Swal.close();
                            this.$Progress.finish();
                            this.$toastr.s("Convidado editado com sucesso.");
                            this.voltaParaConvidados();
                        })
                        .catch((error) => {
                            Swal.close();
                            this.$Progress.fail();
                            this.$toastr.e("Convidado não pode ser editado. Algo aconteceu...");
                        })
                    }
                });
            },
            voltaParaConvidados(){
                this.$router.push('/convidados');
            }
        },
        components: {
            HasError,
            AlertError,
            AlertErrors,
            AlertSuccess
        },
        mounted() {
            if(typeof this.$props.id != 'undefined'){
                axios.get('/api/convidados/'+this.$props.id)
                .then((response) => {
                    if(response.data != {}){
                        this.formConvidados.fill(response.data);
                        this.editMode = true;
                    }else{
                        this.$toastr.e("Não foi possível recuperar este convidado. Tens certeza de que ele existe?");
                    }
                })
            }
        }
    }
</script>
