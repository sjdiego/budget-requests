<template>
    <div>
        <p>Nombre</p>
        <input-text-component
            required
            @input="setName"
            :value="name">
        </input-text-component>

        <p>Email</p>
        <input-text-component
            required
            @input="setEmail"
            :value="email">
        </input-text-component>

        <p>Teléfono</p>
        <input-text-component
            required
            @input="setPhone"
            :value="phone">
        </input-text-component>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                phone: '',
                email: ''
            }
        },
        methods: {
            setName: function(event) {
                this.name = event.target.value
                this.$store.commit('setName', event.target.value)
            },
            setPhone: function(event) {
                this.phone = event.target.value
                this.$store.commit('setPhone', event.target.value)
            },
            setEmail: function(event) {
                let email = event.target.value

                if (email.match(/@hotmail/i)) {
                    alert('Email no valido')
                    this.email = ''
                    this.$store.commit('setEmail', '')
                    return
                }

                this.email = email
                this.$store.commit('setEmail', email)
            }
        }
    }
</script>

<style lang="scss" scoped>
    p {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
