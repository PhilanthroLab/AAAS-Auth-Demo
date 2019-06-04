<template>
    <div class="main">
        <div class="logo">
            <img src="/img/logo_small.png">
        </div>
        <div class="article">
            <div class="question">
                <p class="paragraph">Request Permission</p>
            </div>
            <div class="question">
                <h1>Are you an AAAS member?</h1>
            </div>
            <div class="answers">
                <div>
                    <router-link to="login">YES</router-link>
                </div>
                <div class="disabled">
                    <router-link to="access-granted">NO</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AreYouAUser.vue"
    }
</script>

<style scoped>

</style>