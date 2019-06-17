<template>
    <div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3"><i class="fa fa-user"></i></span>
            </div>
            <input v-model="name" type="text" class="form-control" placeholder="Name" aria-describedby="basic-addon3">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
            </div>
            <input v-model="email" type="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon2"><i class="fa fa-lock"></i></span>
            </div>
            <input v-model="password" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon2">

        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon4"><i class="fa fa-lock"></i></span>
            </div>
            <input v-model="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" aria-describedby="basic-addon2">

        </div>

        <div class="row mt-2">
            <div class="col-md-12 text-center">
                <button @click="loginAttempt" class="btn_1">Register</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <p>
                    <i class="fa fa-lock"></i>
                    By submitting this form you agree to Doctify's Terms of Service

                    We will never display your information publicly. Your information is protected using SSL encryption (same encryption used by banks).
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Register",
        props:['callbackFunction'],
        data(){
            return{
                email:null,
                password:null,
                remember:false,
                password_confirmation:null,
                name:null,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            }
        },
        methods:{
            loginAttempt(){
                let data = new FormData();
                data.append('email',this.email);
                data.append('password',this.password);
                data.append('name',this.name);
                data.append('password_confirmation',this.password_confirmation);
                axios.post('/api/register',data)
                    .then(r=>{
                        if(this.callbackFunction!=undefined)
                            this.callbackFunction();
                        else window.location.reload();
                    })
                    .catch(e=>{
                        for(let i in e.response.data.error){

                            this.$toasted.error(e.response.data.error[i][0],{
                                icon:"error",
                                onClick : (e, toastObject) => {
                                    toastObject.goAway(0);
                                },
                                duration:2000,


                            });
                        }
                    });
            }
        }
    }
</script>

<style scoped>

</style>