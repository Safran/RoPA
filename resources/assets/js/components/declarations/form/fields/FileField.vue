<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="file-field form-group" :class="classes">
        <label class="file-field__label" :for="data.name">{{ data.label }}</label>
        <div class="file-field__container">
            <div class="fieldvalue"  >
                <a :href="data.answer.value.link" class="fieldvalue__file" target="_blank" v-if="data.answer.value">
                    <img :src="`/images/form/attachments/type_${data.answer.value.mime}.svg`"
                         :alt="$e('locale.file_alt')" v-if="data.answer.value.mime !== undefined">
                    <span>{{ data.answer.value.name }}</span>
                </a>
            </div>
            <input type="file" @change="handleUploadFile" ref="uploadfile"
                   :name="'uploadfile' + data.answer.element" :id="'uploadfile' +  data.answer.element"
                   class="inputfile"/>

            <span class="attachment" @click="openFileDialog">
                <img src="../../../../../img/form/file.svg" :alt="$e('locale.file_type-history.upload_alt')">
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "file-field",
        props: {
            data: {
                type: Object,
                required: true,
            },
            readonly: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                element: this.data.answer.element,
                uploadFile: '',
                error: false,
            };
        },
        methods: {
            openFileDialog() {
                this.$refs.uploadfile.click();
            },
            handleUploadFile() {
                this.uploadFile = this.$refs.uploadfile.files[0];
                this.$emit('input', this.uploadFile);
            },
        },
        computed: {
            classes() {
                return {
                    'comments-length__focus': this.showComments,
                    'comments-length__arrow': this.data.length > 0
                }
            },
        },
    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/variables';
    @import '../../../../../styles/mixins';
    @import '../../../../../styles/transitions/fade-transition';

    .file-field {

        margin-left: 9rem;
        padding: 1.5rem 0 .3rem 3.5rem;
        border-left: 0.3rem solid rgba($main-color, .7);
        @include fontSize(14);

        @include mobile {
            margin-left: 7rem;
            padding-left: 2rem;
        }

        &__container {
            position: relative;
            display: flex;

            .fieldvalue {
                position: relative;
                margin-right: .8rem;
                width: 100%;
                height: 30px;
                border-bottom: 1px solid $ip-text-border-color;

                &__file {
                    align-items: center;
                    img {
                        width: 22px;
                        height: 22px;
                        margin-right: 1rem;
                    }
                    span {
                        position: relative;
                        top: .3rem;
                    }
                }
            }
            .attachment {
                position: absolute;
                top: .3rem;
                right: 1rem;
                cursor: pointer;
            }

            .inputfile {
                width: 0.1px;
                height: 0.1px;
                opacity: 0;
                overflow: hidden;
                position: absolute;
                z-index: -1;

                &:focus + span {
                    outline: 1px dotted #000;
                    outline: -webkit-focus-ring-color auto 5px;
                }
            }
        }
    }
</style>