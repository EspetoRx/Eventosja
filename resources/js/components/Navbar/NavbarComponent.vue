<style scoped>
    .container-fluid {
        padding: 0px !important;
    }
    .router-link-active {
        color: #fff !important;
        text-decoration: none;
        background-color: #3490dc;
        border-radius: 10px;
    }
</style>
<template>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <router-link to="/eventos" class="navbar-brand">
                EventosJá
            </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" :class="{'router-link-active': subIsActive('/eventos')}">
                        Eventos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <router-link to="/eventos" class="dropdown-item" exact>
                                Todos os Eventos
                            </router-link>
                            <router-link to="/eventos/create" class="dropdown-item" exact>
                                Criar Evento
                            </router-link>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" :class="{'router-link-active': subIsActive('/convidados')}">
                        Convidados
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <router-link to="/convidados" class="dropdown-item" exact>
                                Todos os Convidados
                            </router-link>
                            <router-link to="/convidados/create" class="dropdown-item" exact>
                                Criar Convidado
                            </router-link>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    export default {
        mounted() {
        },
        methods: {
            /**
             * Método responsável por averiguar se um dos itens filhos do dropdown 
             * está com a class 'active'.
             * Se o estiver, a coloque no pai também.
             */
            subIsActive(input) {
                const paths = Array.isArray(input) ? input : [input];
                return paths.some(path => {
                    return this.$route.path.indexOf(path) === 0 // current path starts with this path string
                });
            }
        }
    }
</script>
