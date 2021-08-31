<style scoped>
.modal{
    display: block;
    overflow: auto !important;
    padding: 0 !important;
    z-index: 1058;
}
.babado{
    background-color: rgba(0,0,0,0.2);
    z-index: 1058;
}
.modal-dialog {
  z-index: 1;
}
footer{
    padding-bottom: 0px;
}
/* Largura da barra de rolagem */
::-webkit-scrollbar {
    width: 0px;
}
</style>
<template>
<!-- Modal -->
    <div>
        <transition-group name="custom-classes-transition"
            enter-active-class="animated slideInDown"
            leave-active-class="animated slideOutUp"
            >
            <div class="modal-backdrop text-dark babado" v-if="this.modalOpen" :key="'1'">
            </div>
            <div class="modal" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static" v-if="this.modalOpen" :key="'2'">
                <div id="modal_body" class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <header>
                                    <slot name="header"></slot>
                                </header>
                            </h5>
                            <button type="button" class="close" @click.prevent="close" aria-label="Fechar">
                                X
                            </button>
                        </div>
                        <div class="modal-body">
                            <main>
                                <slot name="main"></slot>
                            </main>
                        </div>
                        <div class="modal-footer flex-row justify-content-between flex-wrap">
                            <button type="button" class="btn btn-danger float-left" @click.prevent="close"><i class="fa fa-times"></i> Cancelar</button>
                            <footer>
                                <slot name="footer" class="float-right"></slot>
                            </footer>
                            <!-- <button type="button" class="btn btn-secondary"  @click.prevent="close('inner')">Fechar</button>
                            <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </transition-group>
    </div>
</template>

<script>
    export default {
        props: {
            modalOpen: {
                required: true,
            },
        },
        methods: {
            close(e) {
                this.$emit('close');
            }
        }
    }
</script>
