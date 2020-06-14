<template>
    <transition name="flashMessage">
        <div v-if="this.show" style="width: 100%"
             :class="flashMessageClasses"
             v-text="message">
        </div>
    </transition>
</template>

<script>
    import {flashTypes} from "./flashTypes";

    export default {
        data() {
            return {
                show: false,
            }
        },

        props: {
            flashType: {
                type: String,
                default: flashTypes.info,
            },
            message: {
                type: String,
                default: '',
            },
            timeout: {
                type: Number,
                default: 3000
            }
        },

        computed: {
            flashMessageClasses() {
                return {
                    'alert alert-success': this.flashType === flashTypes.success,
                    'alert alert-danger': this.flashType === flashTypes.error,
                    'alert alert-info': this.flashType === flashTypes.info,
                    'alert alert-warning': this.flashType === flashTypes.warning,
                }
            },
        },

        created() {
            setTimeout(() => {
                this.show = true;
            }, 200)

            setTimeout(() => {
                this.$emit('showFlashMessage', false);
            }, this.timeout)
        },
    }

</script>

<style lang="scss">
    @import '../../../scss/global';

    @include flashMessage;
</style>