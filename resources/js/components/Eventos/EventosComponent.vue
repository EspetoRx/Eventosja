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
                <div class="form-control">

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
            
        }),
        methods: {
            getEventos() {
                axios.get('/api/eventos')
                .then((response) => {
                    this.rows = response.data;
                });
            },
            invertModalConvidados() {
                this.modalConvidadosOpened = !this.modalConvidadosOpened;
            },
            openModalConvidados() {
                this.invertModalConvidados();
            },
            closeModalConvidados() {
                this.invertModalConvidados();
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
                        })
                    }
                })
            });
            Fire.$on('convidados', (row) => {
                console.log('Entrei aqui?');
                this.openModalConvidados();
            });
        },
        components: {
            DatatableComponent,
            EditButtonComponent,
            DeleteButtonComponet,
            ConvidadosButtonComponent,
            BootstrapModal,
        }
    }
</script>
