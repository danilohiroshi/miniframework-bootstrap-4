<template>
    <div class="nbr-form">
        <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group">
            <label class="control-label text-primary">Nome:</label>

            <input type="text" name="name" class="form-control" id="name" placeholder="Nome" v-model="name" required>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
            <label class="control-label text-primary">E-mail:</label>

            <input type="email" name="email" class="form-control" id="email" placeholder="exemplo@exemplo.com.br"
                required v-model="email">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
            <label class="control-label text-primary">Mensagem:</label>

            <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="Mensagem" v-model="message"></textarea>
            </div>
        </div>
        </div>
        <div class="text-right">
            <button class="nbr-form-button js-nbr-form-button py-1 px-3" v-on:click="sendEmail">Enviar</button>
        </div>
        <div class="text-center">
            <span class="text-danger">{{errorMessage}}</span>
            <span class="text-primary">{{successMessage}}</span>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {},
    data: function() {
    return {
        name: "",
        email: "",
        message: "",
        errorMessage: "",
        successMessage: ""
    };
    },
    methods: {
        sendEmail: function() {
            if (this.validateButton) {
                this.errorMessage = 'Por favor verifique se você preencheu corretamente todos os campos.';
                this.successMessage = "";
                return;
            }
            this.errorMessage = "";
            this.successMessage = "";
            $(".js-nbr-form-button").html("Enviando...");
            axios.post("/api/contact", {
                name: this.name,
                email: this.email,
                message: this.message
            })
            .then(response => {
                if (typeof response.data.errors !== "undefined") {
                    this.errorMessage = 'Por favor verifique se você preencheu corretamente todos os campos.';
                    return;
                }
                if (typeof response.data.success !== "undefined") {
                    this.successMessage = 'E-mail enviado com sucesso.';
                    return;
                }
            })
            .catch(error => {
                console.log('error');
            })
            .then(() => {
                $(".js-nbr-form-button").html("Enviar");
                $(".js-nbr-form-button").prop('disabled', false);
            });
        }
    },
    computed: {
        validateButton: function() {
            if (this.name == "" || this.email == "" || this.message == "") {
                return true;
            }
            return false;
        }
    }
};
</script>
