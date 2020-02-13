<template>
    <div class="form-group">
        <label :for="inputName">{{textLabel}}</label>
        <input :type="inputType"
               class="form-control"
               :name="inputName"
               :id="inputName"
               v-model="value"
               @blur="handleInputFocusOut($event)"
        />
        <small v-if="smallTextInfo" class="form-text text-muted">{{smallTextInfo}}</small>
    </div>
</template>

<script>
    export default {
        name: "InputTag",
        props: {
            dataValue: { type: [String, Number] },
            inputName: { type: String },
            inputType: { type: String },
            textLabel: { type: String },
            smallTextInfo: { type: String },
        },
        data: function () {
            return {
                value: this.dataValue || null,
            }
        },
        methods: {
            handleInputFocusOut(event) {
                this.$emit('change-input', event.target.name, this.value);
            },
        },
        watch: {
            dataValue: function (newDataValue, oldDataValue) {
                this.value = this.dataValue;
            }
        },
    }
</script>

<style scoped>

</style>