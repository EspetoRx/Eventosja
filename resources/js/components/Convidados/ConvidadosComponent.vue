<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-0 mt-1">
                                Convidados
                            </h4>
                            <router-link to="/convidados/create" class="btn btn-sm btn-link" exact>
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
                            @getData="getConvidados()"
                        ></datatable-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DatatableComponent from '../Common/DatatableComponent.vue';
    import EditButtonComponent from './../Common/EditButtonComponent.vue';
    import DeleteButtonComponet from './../Common/DeleteButtonComponent.vue';
    export default {
        data: () => ({
            columns: [
                {
                    label: 'ID',
                    field: 'id',
                    align: 'center'
                },
                {
                    label: 'Nome',
                    field: 'nome',
                    align: 'center'
                },
                {
                    label: 'E-mail',
                    field: 'email'
                },
                {
                    sortable: false,
                    interpolate: true,
                    component: EditButtonComponent,
                    align: 'center',
                },
                {
                    sortable: false,
                    interpolate: true,
                    component: DeleteButtonComponet,
                    align: 'center'
                },
            ],
            rows: [],
            page: 1,
            filter: '',
            perPage: 10,
        }),
        methods: {
            getConvidados() {
                axios.get('/api/convidados')
                .then((response) => {
                    this.rows = response.data;
                });
            }
        },
        mounted() {
            Fire.$on('update', (row) => {
                this.$router.push('/convidados/edit/'+row.id);
            });
            Fire.$on('deletar', (row) => {
                Confirme.fire({
                    icon: 'warning',
                    title: 'Excluir?',
                    text: 'Tens certeza que desejas excluir este Convidado?',
                })
                .then((response) => {
                    if(response.value){
                        this.$Progress.start();
                        Carregando.fire({
                            title: 'Aguarde...',
                            text: 'Estamos tentando excluir o convidado.',
                        });
                        axios.delete('/api/convidados/'+row.id)
                        .then((res) => {
                            Swal.close();
                            this.$Progress.finish();
                            this.$toastr.s("Convidado excluído com sucesso.");
                            this.getConvidados();
                        })
                        .catch((error) => {
                            Swal.close();
                            this.$Progress.fail();
                        })
                    }
                })
            });
        },
        components: {
            DatatableComponent,
            EditButtonComponent,
            DeleteButtonComponet
        }
    }
</script>
