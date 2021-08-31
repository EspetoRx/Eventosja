<style scoped>
    .invalid-multiselect{
        border: 1px solid #dc3545;
    }
</style>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-0 mt-1">
                                Eventos
                            </h4>
                            <router-link to="/eventos/create" class="btn btn-sm btn-link" exact>
                                +
                            </router-link>
                        </div>

                    </div>

                    <div class="card-body">
                        <datatable-component
                            :columns="columns"
                            :rows="rows"
                            :page="page"
                            :perPage="perPage"
                            :filter="filter"
                            @getData="getEventos()"
                        ></datatable-component>
                    </div>
                </div>
            </div>
        </div>
        <BootstrapModal
            :modalOpen="modalConvidadosOpened"
            @close="closeModalConvidados()">
            <template v-slot:header>
                Convidados
            </template>
            <template v-slot:main>
                <AlertErrors :form="formConvida" message="Houve algo de errado ao realizar este convite..."></AlertErrors>
                <AlertSuccess :form="formConvida" message="Operação realizada com sucesso."></AlertSuccess>
                <div class="form-group">
                    <label for="convidado">Convidado:</label>
                    <vue-multiselect
                        v-model="formConvida.convidado"
                        :options="convidados"
                        :multiple="false"
                        :allow-empty="true"
                        label="nome"
                        track-by="id"
                        selectLabel="Enter p/ selecionar"
                        deselectLabel="Enter p/ deselecionar"
                        selectedLabel="Selecionado"
                        placeholder="Selecione alguém para convidar"
                        :class="{ 'invalid-multiselect': formConvida.errors.has('convidado.id') }"
                        id="convidado"
                    >
                        <template slot="noResult">Nenhum resultado encontrado.</template>
                        <template slot="noOptions">Não há nada pra ser selecionado.</template>
                    </vue-multiselect>
                </div>
                <div class="form-group float-right" v-if="formConvida.convidado">
                    <button type="button" role="button" class="btn btn-sm btn-success" @click.prevent="convidar()">Convidar</button>
                </div>
                <div class="form-group" v-if="formConvida.evento.convidados.length > 0">
                    <h5>Convidados</h5>
                    <ul>
                        <li v-for="(el, i) in formConvida.evento.convidados" :key="i">
                            {{ el.nome }} <button class="btn btn-sm btn-link text-danger text-decoration-none" @click.prevent="desconvidar(el.pivot.id, el.nome)">Desconvidar</button>
                        </li>
                    </ul>
                </div>
                <div class="form-group" v-else>
                    <h5>Convidados</h5>
                    <p>Você ainda não convidou ninguém. Selecione um convidado acima para enviar um convite.</p>
                </div>
            </template>
        </BootstrapModal>
    </div>
</template>

<script>
    import DatatableComponent from '../Common/DatatableComponent.vue';
    import EditButtonComponent from './../Common/EditButtonComponent.vue';
    import DeleteButtonComponet from './../Common/DeleteButtonComponent.vue';
    import ConvidadosButtonComponent from './../Common/ConvidadosButtonComponent.vue';
    import BootstrapModal from './../Common/BootstrapModal.vue';
    import Form from 'vform';
    import {HasError, AlertError, AlertSuccess, AlertErrors} from 'vform/src/components/bootstrap4';
    import moment from 'moment';
    export default {
        data: () => ({
            columns: [
                {
                    label: 'ID',
                    field: 'id',
                    align: 'center'
                },
                {
                    label: 'Data do Evento',
                    field: 'data_evento',
                    representedAs: ({data_evento}) => (moment(data_evento).format('DD/MM/YYYY')),
                    align: 'center'
                },
                {
                    label: 'Descrição do Evento',
                    field: 'descricao'
                },
                {
                    sortable: false,
                    component: ConvidadosButtonComponent,
                    align: 'center'
                },
                {
                    sortable: false,
                    component: EditButtonComponent,
                    align: 'center',
                },
                {
                    sortable: false,
                    component: DeleteButtonComponet,
                    align: 'center'
                },
            ],
            rows: [],
            page: 1,
            filter: '',
            perPage: 10,
            modalConvidadosOpened: false,
            convidados: [],
            formConvida: new Form({
                evento: '',
                evento_id: '',
                convidado: '',
                convidado_id: '',
            }),
        }),
        methods: {
            getEventos() {
                axios.get('/api/eventos')
                .then((response) => {
                    this.rows = response.data;
                });
            },
            getConvidados(){
                axios.get('/api/convidados')
                .then((response) => {
                    this.convidados = response.data;
                })
            },
            invertModalConvidados() {
                this.modalConvidadosOpened = !this.modalConvidadosOpened;
            },
            openModalConvidados() {
                this.invertModalConvidados();
            },
            closeModalConvidados() {
                this.formConvida.clear();
                this.formConvida.reset();
                this.getEventos();
                this.invertModalConvidados();
            },
            convidar(){
                Confirme.fire({
                    title: 'Convidar?',
                    text: 'Tem certeza de que deseja convidar ' + this.formConvida.convidado.nome + ' para o evento do dia ' + moment(this.formConvida.evento.data_evento).format('DD/MM/YYYY') + '?'
                })
                .then((response) => {
                    if(response.value){
                        this.$Progress.start();
                        Carregando.fire({
                            title: 'Aguarde...',
                            text: 'Extamos tentando convidar ' + this.formConvida.convidado.nome + '...'
                        });
                        this.formConvida.post('/api/convidados_eventos')
                        .then((res) => {
                            this.formConvida.evento = res.data.evento;
                            this.formConvida.convidado = '';
                            Swal.close();
                            this.$Progress.finish();
                            this.$toastr.s("Convite realizado com sucesso.");
                        })
                        .catch((error) => {
                            Swal.close();
                            this.$Progress.fail();
                            this.$toastr.e("Convite não pode ser realizado. Algo aconteceu...");
                        })
                    }
                });
            },
            desconvidar(id, nome){
                Confirme.fire({
                    icon: 'warning',
                    title: 'Desconvidar?',
                    text: 'Tem certeza de que deseja desconvidar ' + nome + ' para o evento do dia ' + moment(this.formConvida.evento.data_evento).format('DD/MM/YYYY') + '?'
                })
                .then((response) => {
                    if(response.value){
                        this.$Progress.start();
                        Carregando.fire({
                            title: 'Aguarde...',
                            text: 'Extamos tentando desconvidar ' + nome + '...'
                        });
                        this.formConvida.delete('/api/convidados_eventos/'+id)
                        .then((res) => {
                            this.formConvida.evento = res.data;
                            this.formConvida.convidado = '';
                            Swal.close();
                            this.$Progress.finish();
                            this.$toastr.s("Convite retirado com sucesso.");
                        })
                        .catch((error) => {
                            Swal.close();
                            this.$Progress.fail();
                            this.$toastr.e("Convite não pode ser removido. Algo aconteceu...");
                        })
                    }
                });
            }
        },
        mounted() {
            Fire.$on('update', (row) => {
                this.$router.push('/eventos/edit/'+row.id);
            });
            Fire.$on('deletar', (row) => {
                Confirme.fire({
                    icon: 'warning',
                    title: 'Excluir?',
                    text: 'Tens certeza que desejas excluir este Evento?',
                })
                .then((response) => {
                    if(response.value){
                        this.$Progress.start();
                        Carregando.fire({
                            title: 'Aguarde...',
                            text: 'Estamos tentando excluir o evento.',
                        });
                        axios.delete('/api/eventos/'+row.id)
                        .then((res) => {
                            Swal.close();
                            this.$Progress.finish();
                            this.$toastr.s("Evento excluído com sucesso.");
                            this.getEventos();
                        })
                        .catch((error) => {
                            Swal.close();
                            this.$Progress.fail();
                            console.log(error.response);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: (error.response.data.errors != '')?error.response.data.errors.impossivel_excluir:'Eita, o que será que aconteceu?',
                                confirmButtonColor: '#6cb2eb',
                                confirmButtonText: 'Fazer o quê, né...'
                            });
                        })
                    }
                })
            });
            Fire.$on('convidados', (row) => {
                this.formConvida.evento = row;
                this.openModalConvidados();
            });
            this.getConvidados();
        },
        computed: {
            console: () => console
        },
        components: {
            DatatableComponent,
            EditButtonComponent,
            DeleteButtonComponet,
            ConvidadosButtonComponent,
            BootstrapModal,
            HasError,
            AlertError,
            AlertErrors,
            AlertSuccess
        }
    }
</script>
