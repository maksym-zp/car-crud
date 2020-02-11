<template>
    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" @change="onFileChange" id="customFileLang" lang="en">
            <label class="custom-file-label" for="customFileLang">Select image</label>
        </div>
        <img  v-if="url" class="img-thumbnail"  :src="url"/>
        <button
                v-if="url"
                type="submit"
                class="btn btn-primary"
                v-on:click="save($event)"
                :disabled="buttonDisabled"
        >
            Upload image
        </button>
    </div>
</template>

<script>
    import EventBus from './../event-bus';
    export default {
        name: "ImageUploader",
        data() {
            return {
                url: this.image.url ? 'storage/'+this.image.url : null,
                file: null,
                buttonDisabled: false,
            }
        },
        props: ['image'],
        methods: {
            onFileChange(e) {

                const file = e.target.files[0];
                if (!file.name.match(/.(jpg|jpeg|ico|png|gif)$/i)) {
                    this.url = null;
                    this.file = null;
                    this.buttonDisabled = true;
                    alert('not an image');
                } else {
                    this.file = file;
                    this.url = URL.createObjectURL(file);
                    this.buttonDisabled = false;
                }


            },
            checkType(file) {

                if (!file.name.match(/.(jpg|jpeg|ico|png|gif)$/i))
                    alert('not an image');
            },
            save(e){
                e.preventDefault();
                let data = new FormData();
                if(this.file){
                    let image = this.file;

                    //data.append('name', 'image');
                    data.append('image', image);

                    let config = {
                        header : {
                            'Content-Type' : 'multipart/form-data'
                        }
                    };

                    axios.post('/upload-image', data, config).then((response) => {
                        if(response.data.url){
                            var newUrl = response.data.url;
                            this.url = 'storage/'+ newUrl;
                            EventBus.$emit('new-url', newUrl);
                        }else if(response.data.error){
                            alert(response.data.error);
                        }
                    }).catch((errors) => {
                        let message = errors.response.data.errors.image[0];
                        alert(message)
                    });
                }else{
                    alert('Select new image first!')
                }

            }
        }
    }
</script>
