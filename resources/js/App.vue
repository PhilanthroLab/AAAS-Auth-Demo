<template>
    <transition name="fade" mode="out-in" @beforeLeave="beforeLeave" @enter="enter" @afterEnter="afterEnter">
        <router-view></router-view>
    </transition>
</template>

<script>
    export default {
        name: "App",
        methods: {
            beforeLeave(element) {
                this.prevHeight = getComputedStyle(element).height;
            },
            enter(element) {
                const { height } = getComputedStyle(element);

                element.style.height = this.prevHeight;

                setTimeout(() => {
                    element.style.height = height;
                });
            },
            afterEnter(element) {
                element.style.height = 'auto';
            },
        }
    }
</script>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition-duration: 0.3s;
        transition-property: height, opacity;
        transition-timing-function: ease;
        overflow: hidden;
    }

    .fade-enter,
    .fade-leave-active {
        opacity: 0
    }
</style>