<template>
    <div class="main">
        <div class="logo">
            <img src="/img/logo_small.png">
        </div>
        <div class="article">
<!--            <div class="question">-->
<!--                <p class="paragraph">User Account Verified!</p>-->
<!--            </div>-->
            <div class="question">
                <h1>Are you an author of the review<span class="italic"></span>?</h1>
            </div>
            <div class="answers">
                <div>
                    <router-link to="/select-author">YES</router-link>
                </div>
                <div class="disabled ">
                    <a @click.prevent="proceed" href="" class="ld-ext-right" :class="{running: isLoading}" :disabled="isLoading">
                        NO
                        <div class="ld ld-ring ld-spin"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AreYouTheAuthor",
        data: () => ({
            isLoading: false
        }),
        methods: {
            proceed () {
                let data = {
                    is_author: false,
                    selected_author: null,
                }
                this.isLoading = true
                axios.post('/internal-api/proceed', data)
                    .then(res => {
                        if (res.data.status === 'success') {
                            let jwt = res.data.data
                            if (window.opener) {
                                window.opener.postMessage({'status': 'success', 'case': 'member', 'jwt': jwt}, '*')
                            }
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => {this.isLoading = false})
            }
        }
    }
</script>

<style scoped>

</style>