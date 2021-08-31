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
        <BootstrapModal
            :modalOpen="modalEventosOpened"
            @close="closeModalConvidados()">
            <template v-slot:header>
                Convidados
            </template>
            <template v-slot:main>
                <AlertErrors :form="formConvida" message="Houve algo de errado ao realizar este convite..."></AlertErrors>
                <AlertSuccess :form="formConvida" message="Operação realizada com sucesso."></AlertSuccess>
                <div class="form-group">
                    <label for="evento">Evento:</label>
                    <vue-multiselect
                        v-model="formConvida.evento"
                        :options="eventos"
                        :multiple="false"
                        :allow-empty="true"
                        :custom-label="customLabel"
                        track-by="id"
                        selectLabel="Enter p/ selecionar"
                        deselectLabel="Enter p/ deselecionar"
                        selectedLabel="Selecionado"
                        placeholder="Selecione um evento"
                        :class="{ 'invalid-multiselect': formConvida.errors.has('evento.id') }"
                        id="evento"
                    >
                        <template slot="noResult">Nenhum resultado encontrado.</template>
                        <template slot="noOptions">Não há nada pra ser selecionado.</template>
                    </vue-multiselect>
                </div>
                <div class="form-group float-right" v-if="formConvida.evento">
                    <button type="button" role="button" class="btn btn-sm btn-success" @click.prevent="convidar()">Convidar</button>
                </div>
                <div class="form-group" v-if="formConvida.convidado.eventos.length > 0">
                    <h5>Eventos</h5>
                    <ul>
                        <li v-for="(el, i) in formConvida.convidado.eventos" :key="i">
                            {{ customLabel(el) }} <button class="btn btn-sm btn-link text-danger text-decoration-none" @click.prevent="desconvidar(el.pivot.id, el.nome)">Desconvidar</button>
                        </li>
                    </ul>
                </div>
                <div class="form-group" v-else>
                    <h5>Eventos</h5>
                    <p>Este ainda não se encontra associado a nenhum evento.</p>
                </div>
            </template>
        </BootstrapModal>
    </div>
</template>

<script>
    import DatatableComponent from '../Common/DatatableComponent.vue';
    import EditButtonComponent from './../Common/EditButtonComponent.vue';
    import DeleteButtonComponet from './../Common/DeleteButtonComponent.vue';
    import EventosButtonComponent from './../Common/EventosButtonComponent.vue';
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
                    component: EventosButtonComponent,
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
            modalEventosOpened: false,
            eventos: [],
            formConvida: new Form({
                evento: '',
                evento_id: '',
                convidado: '',
                convidado_id: '',
            }),
        }),
        methods: {
            getConvidados() {
                axios.get('/api/convidados')
                .then((response) => {
                    this.rows = response.data;
                });
            },
            getEventos() {
                axios.get('/api/eventos')
                .then((response) => {
                    this.eventos = response.data;
                });
            },
            invertModalEventos() {
                this.modalEventosOpened = !this.modalEventosOpened;
            },
            openModalEventos() {
                this.invertModalEventos();
            },
            closeModalConvidados() {
                this.formConvida.clear();
                this.formConvida.reset();
                this.getConvidados();
                this.invertModalEventos();
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
            },
            customLabel({data_evento}){
                return moment(data_evento).format('DD/MM/YYYY');
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
            Fire.$on('eventos', (row) => {
                console.log(row);
                this.formConvida.convidado = row;
                this.openModalEventos();
            });
            this.getEventos();
        },
        components: {
            DatatableComponent,
            EditButtonComponent,
            DeleteButtonComponet,
            EventosButtonComponent,
            BootstrapModal,
            HasError,
            AlertError,
            AlertErrors,
            AlertSuccess
        }
    }
</script>
