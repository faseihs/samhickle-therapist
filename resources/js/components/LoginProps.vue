<template>
    <div>
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
        <div class="form-check">
            <input v-model="remember" type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Remember</label>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 text-center">
                <button @click="loginAttempt" class="btn_1">Login</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12 text-left">
                <a :href="getResetLink()" class="btn btn-sm btn-link">Forgot Password</a>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Login",
        props:['url','type'],
        data(){
            return{
                email:null,
                password:null,
                remember:false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            }
        },
        methods:{
            getResetLink(){
                if(this.type==='user')
                    return '/password/reset'
                else  return '/therapist/password/reset'
            },
            loginAttempt(){
                let data = new FormData();
                data.append('email',this.email);
                data.append('password',this.password);
                data.append('remember',this.remember);
                axios.post(this.url,data)
                    .then(r=>{
                        window.location.reload();
                    })
                    .catch(e=>{
                        this.$toasted.error('Wrong Credentials',{
                            icon:"error",
                            onClick : (e, toastObject) => {
                                toastObject.goAway(0);
                            },
                            duration:2000,

                        });
                    });
            }
        }
    }
</script>

<style scoped>

</style>