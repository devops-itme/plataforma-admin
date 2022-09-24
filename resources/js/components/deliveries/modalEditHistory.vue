<template>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="max-width: 95% !important;" class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
           <div class="modal-header">
                <slot name="header"> default header </slot>
            </div>
            <div class="modal-body">
                <slot name="body"> default body </slot>
            </div>
            <div class="modal-footer">
                <slot name="footer"> default footer </slot>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
export default {
    props: {

    },

    data() {
        return {

        }
    },
    components: {

    }

}
</script>
