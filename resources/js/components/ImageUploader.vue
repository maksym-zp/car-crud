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
    export default {
        name: "ImageUploader",
        data() {
            return {
                url: this.imageUrl ? 'storage/'+this.imageUrl : null,
                file: null,
                buttonDisabled: false,
            }
        },
        props: ['imageUrl'],
        methods: {
            onFileChange(e) {
                const file = e.target.files[0];
                if (!this.beforeUpload(file)) {
                    this.url = null;
                    this.file = null;
                    this.buttonDisabled = true;
                } else {
                    this.file = file;
                    this.url = URL.createObjectURL(file);
                    this.buttonDisabled = false;
                }
            },
            beforeUpload(file) {
                let isImage = this.checkType(file);
                let isLt2M = this.checkSize(file);
                return isImage && isLt2M;
            },
            checkType(file) {
                let isImage = file.name.match(/.(jpg|jpeg|ico|png|gif)$/i);
                if (!isImage){
                    alert('not an image');
                }
                return isImage;
            },
            checkSize(file) {
                let isLt2M = file.size / 1024 / 1024 < 2;
                if (!isLt2M) {
                    alert('Image must smaller than 2MB!');
                }
                return isLt2M;
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
                            this.$emit('change-image', '/upload-image', newUrl);
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
