<template>
    <div class="c-vue-form">
        <div class="c-vue-form__header">
            <div class="c-vue-form__header--title u-fpc">Solicita presupuestos</div>
            <div class="c-vue-form__header--text u-fpc">¡Es gratis!</div>
        </div>
        <form-wizard
            color="#ff7300"
            shape="tab"
            title=""
            subtitle=""
            nextButtonText="Siguiente"
            backButtonText="Anterior"
            finishButtonText="Finalizar">

            <tab-content title="Descripción" :before-change="checkDescription">
                <description-tab-component></description-tab-component>
            </tab-content>

            <tab-content title="Categoría" :before-change="checkCategory">
                <category-tab-component></category-tab-component>
            </tab-content>

            <tab-content title="Datos" :before-change="onSubmit">
                <clientdata-tab-component></clientdata-tab-component>
            </tab-content>

            <tab-content title="Resumen">
                <div class="c-vue-form__success u-fpc">
                    <p>Presupuesto recibido</p>
                </div>
            </tab-content>
        </form-wizard>
    </div>
</template>

<script>
import VueFormWizard from "vue-form-wizard/src"
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

Vue.use(VueFormWizard);

export default {
    mounted() {
        console.log('RequestForm component loaded.')
    },
    methods: {
        checkDescription: function() {
            let description = this.$store.getters.description

            if (typeof description === 'undefined' || description === null || description.length <= 5) {
                alert('Debes completar la descripción antes de continuar')
                return false
            }

            return true
        },
        checkCategory: function() {
            let category = this.$store.getters.category

            if (typeof category === 'undefined' || category === null || category.length < 1) {
                alert('Debes seleccionar una categoría antes de continuar')
                return false
            }

            return true
        },
        onSubmit: function() {
            let email = this.$store.getters.email,
                phone = this.$store.getters.phone

            if (typeof email === 'undefined'
                || email === null
                || email.length <= 3)
            {
                alert('Debes introducir tu email antes de continuar')
                return false
            }

            if (typeof phone === 'undefined'
                || phone === null
                || phone.length <= 3)
            {
                alert('Debes introducir tu teléfono antes de continuar')
                return false
            }


            return new Promise((resolve, reject) => {
                axios
                    .post(process.env.MIX_APP_URL + '/api/budget/create', {
                        title: '-',
                        category_id: this.$store.getters.category,
                        description: this.$store.getters.description,
                        email: this.$store.getters.email,
                        phone: this.$store.getters.phone,
                        address: '-',
                    })
                    .then(response => {
                        resolve(true)
                    })
                    .catch(error => {
                        console.log(error);
                        reject('Ha ocurrido un error al procesar el envio')
                    })
            })

        }
    }
}
</script>

<style lang="scss" scoped>
    .c-vue-form {
        background-color: #fff;
        border: 1px solid #1d2124;
        height: 100%;

        &__header {
            height: 40px;
            display: flex;
            flex-direction: row;
            flex: 1;

            &--title {
                background-color: #404040;
                color: #fff;
                flex: 1;
            }

            &--text {
                background-color: #ff7300;
                color: #fff;
            }
        }

        &__success {
            justify-content: center;
            margin-top: 3em;
            margin-bottom: 3em;

            p {
                font-size: 2em;
            }
        }
    }

    .u-fpc {
        display: flex;
        align-items: center;
        padding: 10px;
        font-weight: bold;
        font-size: 1.2em;
    }
</style>
