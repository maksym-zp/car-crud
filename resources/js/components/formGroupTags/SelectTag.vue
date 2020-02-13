<template>
    <div class="form-group">
        <label :for="selectType">{{textLabel}}</label>
        <select v-model="selectedItem"
                @change="onChange($event)"
                :name="selectType"
                :id="selectType"
                class="form-control">
            <option disabled value="" :id="selectType">Select {{selectType}}</option>
            <option v-for="item in dataArray"
                    v-bind:value="item.id ? item.id : item"
                    :key="item.id ? item.id : item">
                {{item.name ? item.name : item}}
            </option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "SelectTag",
        props: {
            dataArray: {type: [Array, Object] },
            selected: { type: [String, Number] },
            selectType: { type: String },
            textLabel: { type: String },
        },
        data: function () {
            return {
                selectedItem: this.selected || null,
            }
        },
        methods: {
            onChange(event) {
                this.$emit('change-select', event.target.name, this.selectedItem);
            },
        },
        watch: {
            selected: function (newSelected, oldSelected) {
                this.selectedItem = this.selected;
            }
        },
    }
</script>

<style scoped>

</style>