<template>
    <form>
        <tabs>
            <tab title="Page 1">
                <InputTag
                        @change-input="handleChangeInput"
                        :dataValue="carData.name"
                        inputName="name"
                        inputType="text"
                        textLabel="Case: "
                        smallTextInfo="Case is required for saving other fields."
                />
                <SelectTag
                        @change-select="handleChangeSelect"
                        :dataArray="this.brands"
                        :selected="carData.brand_id"
                        selectType="brand"
                        textLabel="Make: "
                />
                <SelectTag
                        @change-select="handleChangeSelect"
                        :dataArray="this.modelsData"
                        :selected="carData.model_id"
                        selectType="model"
                        textLabel="Model: "
                />
                <InputTag
                        @change-input="handleChangeInput"
                        :dataValue="carData.milage"
                        inputName="milage"
                        inputType="number"
                        textLabel="Milage: "
                />
                <div class="form-group">
                    <label for="buying">Buying Date: </label>
                    <datepicker
                            input-class="form-control"
                            wrapper-class="form-group"
                            name="buying"
                            id="buying"
                            v-model="carData.buying"
                            :format="customFormatter"
                            @selected="selectedBuying"
                    ></datepicker>
                </div>
            </tab>
            <tab title="Page 2">
                <SelectTag
                        @change-select="handleChangeSelect"
                        :dataArray="this.colors"
                        :selected="carData.color_id"
                        selectType="color"
                        textLabel="Color: "
                />
                <SelectTag
                        v-if="(this.carData.model_id === this.canHasDriveTrain)"
                        @change-select="handleChangeSelect"
                        :dataArray="this.driveTrainVariables"
                        :selected="carData.drivetrain"
                        selectType="drivetrain"
                        textLabel="Drivetrain: "
                />
                <ImageUploader :image-url="this.imageUrl" @change-image="handleChangeImage"></ImageUploader>
            </tab>
        </tabs>
        <button type="submit"
                class="btn btn-primary"
                :disabled="buttonDisabled"
                v-on:click="getQuote($event)"
        >Get quote
        </button>
    </form>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';
    import {Tabs, Tab} from 'vue-slim-tabs'
    import ImageUploader from './ImageUploader';
    import SelectTag from './formGroupTags/SelectTag';
    import InputTag from './formGroupTags/InputTag';

    export default {
        name: "CarComponent",
        props: {
            user: {type: Number, required: true},
            car: {type: [Object, Array], required: true},
            brands: {type: Array, required: true},
            models: {type: Array, required: true},
            colors: {type: Array, required: true},
            canHasDriveTrain: {type: Number, required: true},
            driveTrainVariables: {type: Array, required: true},
            urlImage: {type: String}
        },
        data: function () {
            return {
                carModel: [],
                carData: {...this.car} || {},
                imageUrl: this.urlImage || '',
                modelsData: {...this.models} || {},
                buttonDisabled: false
            }
        },
        components: {
            Datepicker, Tabs, Tab, ImageUploader, SelectTag, InputTag
        },
        methods: {
            handleChangeSelect(name, value) {
                if (name === 'brand') {
                    this.carData.brand_id = value;
                    this.carData.model_id = null;
                    this.getModelsByBrand(value)
                } else if (name === 'model') {
                    this.carData.model_id = value;
                    if (parseInt(value) !== this.canHasDriveTrain && this.carData.drivetrain) {
                        this.carData.drivetrain = 0;
                    }

                } else if (name === 'color') {
                    this.carData.color_id = value;
                } else {
                    this.carData[name] = value;
                }

                this.updatedFormData();
            },
            handleChangeInput(name, value) {
                switch (name) {
                    case 'milage':
                        if (value > 100000) {
                            this.buttonDisabled = true;
                            alert('We can insure your car');
                        } else {
                            this.buttonDisabled = false;
                            this.updatedFormData();
                        }
                        break;
                    default:
                        this.carData[name] = value;
                        this.updatedFormData();
                        break;
                }
            },
            updatedFormData() {
                let data = this.checkBuyingFormat();
                if (data.name && data.name.length > 0) {

                    Object.filter = (obj, predicate) =>
                        Object.keys(obj)
                            .filter(key => predicate(obj[key]))
                            .reduce((res, key) => (res[key] = obj[key], res), {});


                    var filtered = Object.filter(data, value => value !== null);

                    let uri = '/car/update';
                    axios.put(uri, filtered).then((response) => {
                        console.log('response', response.data);
                    }).catch((errors) => {
                        this.getErrorMessages(errors);
                    });
                } else {
                    alert('Write case text first !');
                }
            },
            getModelsByBrand(id) {
                let uri = '/brand/' + id;
                axios.get(uri).then((response) => {
                    if (response.data) {
                        this.modelsData = response.data;
                    }
                }).catch((errors) => {
                    this.getErrorMessages(errors);
                });
            },
            getDriveTrainVariables() {
                let uri = '/drive-train';
                axios.get(uri).then((response) => {
                    if (response.data) {
                        this.driveTrainVariablesData = response.data;
                    }
                }).catch((errors) => {
                    this.getErrorMessages(errors);
                });
            },
            customFormatter(date) {
                return moment(date).format('YYYY-MM-DD');
            },
            selectedBuying(date) {
                this.carData.buying = moment(date).format('YYYY-MM-DD');
                this.updatedFormData();
            },
            checkBuyingFormat() {
                let data = {...this.carData};
                if (data.buying) {
                    data.buying = moment(this.carData.buying).format('YYYY-MM-DD');
                }
                return data;
            },
            handleChangeImage(name, value){
                this.imageUrl = value;
            },
            getQuote(e) {
                e.preventDefault();
                alert('getQuote');
            },
            getErrorMessages(errors) {
                let errorsArray = errors.response.data.errors;
                let errorsText = Object.keys(errorsArray).map(function (key, index) {
                    return key + ":" + errorsArray[key][0];
                });
                alert(errorsText);
            }
        }
    }
</script>
<style module>
    .vue-tablist {
        list-style: none;
        display: flex;
        padding-left: 0;
        border-bottom: 1px solid #e2e2e2;
    }

    .vue-tab {
        padding: 5px 10px;
        cursor: pointer;
        user-select: none;
        border: 1px solid transparent;
        border-bottom-color: #e2e2e2;
        border-radius: 3px 3px 0 0;
        background-color: white;
        position: relative;
        bottom: -1px;
    }

    .vue-tab[aria-selected="true"] {
        border-color: #e2e2e2;
        border-bottom-color: transparent;
    }

    .vue-tab[aria-disabled="true"] {
        cursor: not-allowed;
        color: #999;
    }

</style>