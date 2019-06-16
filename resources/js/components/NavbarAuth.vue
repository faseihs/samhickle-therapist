<template>

    <li v-show="showLi" class="submenu">
        <a href="#0" class="show-submenu">Login/Signup<i class="icon-down-open-mini"></i></a>
        <ul>
            <li><span class="menu-s">Patients </span> <a @click.prevent="showLogin" class="d-inline-block menu-a" href="/login">Login</a><a @click.prevent="showRegister" class="d-inline-block menu-a" href="/register">Register</a>
            </li>

            <li><span class="menu-s">Therapist  </span> <a @click.prevent="showtLogin" class="d-inline-block menu-a" href="/therapist/login">Login</a><a  class="d-inline-block menu-a" href="/plans">Register</a></li>


        </ul>

        <modal  height="auto" name="LoginModal">
            <div class="container p-2">
                <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
                <login url="/api/login"></login>
            </div>
        </modal>
        <modal  height="auto" name="registerModal">
            <div class="container p-2">
                <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
                <register url="/api/register"></register>
            </div>
        </modal>
        <modal  height="auto" name="tLoginModal">
            <div class="container p-2">
                <login url="/api/t-login"></login>
            </div>
        </modal>
        <modal  height="auto" name="tregisterModal">
            <div class="container p-2">
                <register url="/api/t-register"></register>
            </div>
        </modal>

    </li>


</template>

<script>
    import moment from 'moment';
    import Login from './LoginProps.vue';
    import Register from './RegisterProps.vue';
    export default {
        name: "NavbarAuth",
        props:['name'],
        components:{
            'login':Login,
            'register':Register
        },
        data(){
            return {
                Name:this.UcFirst(this.name)
            }
        },
        methods:{
            UcFirst(string)
            {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
            showLogin(){
                this.$modal.show('LoginModal');
            }
            ,
            showRegister(){
                this.$modal.show('registerModal');
            },
            showtLogin(){
                this.$modal.show('tLoginModal');
            }
            ,
            showtRegister(){
                this.$modal.show('tregisterModal');
            },
            getUrl(){
              if(this.name==='patients')
                  return '/api/login';
              else return '/api/therapist-login'
            },
            getUrlReg(){
                if(this.name==='patients')
                    return '/api/register';
                else return '/api/therapist-register'
            },
            showLi(){
                console.log(window.auth);
                return window.auth==='false';
            }
        }
    }
</script>

<style scoped>

</style>