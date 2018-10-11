<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div>
        <div class="comments" :class="readonly ? 'comments-locked' : ''">
            <div class="comments-length" :class="classes" @click="toggleComments"
                 v-if="data.answer.comments.length > 0">
                <p>{{ $c('locale.comments', data.answer.comments.length) }}</p>
            </div>

            <transition name="fade">
                <div class="comments-wrapper">
                    <div class="comments-item" v-if="showComments && data.answer.comments.length > 0"
                         v-for="comment in data.answer.comments">
                        <div class="comments-item__header">
                            <span class="bold">{{ comment.author }}</span>
                            <span>{{ moment(comment.created.date) }}</span>
                        </div>
                        <p>{{ comment.body}}</p>
                        <a :href="comment.attachments[0].link" class="comments-item__attachment"
                           v-if="comment.attachments.length > 0" target="_blank">
                            <img :src="`/images/form/attachments/${comment.attachments[0].type}.svg`"
                                 :alt="$e('locale.attachment_alt')">
                            <span>{{ comment.attachments[0].name }}</span>
                        </a>
                    </div>
                </div>
            </transition>

            <div class="comments-bottom" v-if="!readonly">
                <span>{{ $e('locale.comments-history.title') }}</span>

                <div class="comments-bottom__input">
                    <div class="textarea">
                    <textarea name="comment"
                              id="comment"
                              v-model="commentBody"
                              :placeholder="$e('locale.comments-history.new-comment-placeholder')">
                    </textarea>
                        <input type="file" @change="handleUpload" ref="attachment"
                               :name="'attachment' + data.answer.element" :id="'attachment' +  data.answer.element"
                               class="inputfile"/>

                        <span class="attachment" @click="openFileDialog">
                        <img src="./../../../../img/form/file.svg" :alt="$e('locale.comments-history.attachment_alt')">
                    </span>
                    </div>
                    <button :class="buttonClasses" @click="sendComment">{{ $e('locale.comments-history.answer-button') }}</button>
                </div>

                <div class="comments-bottom__models" v-if="role === 'admin' || role === 'lawyer'">
                    <button v-if="role === 'admin'"
                            class="btn-chevron"
                            @click="showModelModal">
                        {{ $e('locale.comment-templates.save-button') }}
                    </button>

                    <div class="comments-bottom__models-wrapper" v-if="data.commenttemplates.length > 0">
                        <button class="btn-chevron" @click="toggleModels">
                            {{ $e('locale.comment-templates.search-template') }}
                        </button>

                        <div v-if="showModels">
                            <input v-model="search" id="search"
                                   :placeholder="$e('locale.comment-templates.search-template-placeholder')">

                            <ul class="comments-bottom__models-list">
                                <li v-for="model in filteredModels" :key="model.id">
                                    <p @click="useModel(model)">{{ model.title }}</p>
                                    <span class="model-delete" @click="deleteModel(model)" v-if="role === 'admin'">
                                <img src="./../../../../img/form/trash.svg"
                                     :alt="$e('locale.comment-templates.delete_alt')">
                            </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="error" class="comments-error-message">{{ error }}</div>
    </div>
</template>

<script>
    export default {
        name: "comments",
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
                showComments: false,
                showModels: false,
                role: window.App.user.role,
                element: this.data.answer.element,
                search: '',
                commenttemplates: this.data.commenttemplates,
                commentBody: '',
                modelTitle: '',
                uploadFile: '',
                error: false,
            }
        },
        methods: {
            toggleComments() {
                this.showComments = !this.showComments;
            },
            toggleModels() {
                this.showModels = !this.showModels;
            },
            moment(date) {
                return this.$moment(date).locale(window.App.locale).fromNow();
            },
            openFileDialog() {
                this.$refs.attachment.click();
            },
            sendComment() {
                if (this.commentBody.length > 0) {
                    let postData = new FormData();
                    postData.append('body', this.commentBody);
                    postData.append('attachment', this.uploadFile);

                    axios.post(this.$url('/comments/' + this.data.answer.id),
                        postData).then(response => {
                        this.data.answer.comments.push({
                            body: response.data.body,
                            created: response.data.created,
                            author: response.data.author,
                            attachments: response.data.attachment,
                        });
                        this.commentBody = '';
                        this.uploadFile = '';
                        this.error = '';
                    }).catch(error => {
                        this.error = error.response.data.errors.attachment[0];
                    });
                }
            },
            showModelModal() {
                if (this.commentBody.length > 0) {
                    this.$modal.show('save-model', {
                        id: this.element,
                        body: this.commentBody
                    });
                }
            },
            useModel(model) {
                axios.get(this.$url('/commenttemplates/' + model.id + '/body')).then((response) => {
                    //console.log(response);
                    this.commentBody = response.data.body.body
                })
            },
            deleteModel(model) {
                let index = this.commenttemplates.map(item => item.id).indexOf(model.id);
                this.commenttemplates.splice(index, 1);

                axios.delete(this.$url('/commenttemplates/' + model.id + '/delete'));


            },
            handleUpload() {
                this.uploadFile = this.$refs.attachment.files[0];
            },
        },
        computed: {
            classes() {
                return {
                    'comments-length__focus': this.showComments,
                    'comments-length__arrow': this.data.length > 0
                }
            },
            buttonClasses() {
                return {
                    'btn-primary btn-primary__small': this.commentBody,
                    'btn-secondary btn-secondary__small': !this.commentBody
                }
            },
            filteredModels() {
                return this.commenttemplates.filter(model => {
                    return model.title.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        }
    }
</script>

<style lang="scss">
    @import '../../../../styles/colors';
    @import '../../../../styles/variables';
    @import '../../../../styles/mixins';
    @import '../../../../styles/transitions/fade-transition';

    .comments {
        margin-left: 9rem;
        padding: 1.5rem 0 .3rem 3.5rem;
        border-left: 0.3rem solid rgba($main-color, .7);
        @include fontSize(14);

        @include mobile {
            margin-left: 7rem;
            padding-left: 2rem;
        }

        &-locked {
            padding: 0 0 0 3.5rem;
            border-color: rgba($grey, .5);

            .comments-length {
                padding-top: 1.5rem;
            }
        }

        &-length {
            padding-bottom: 1.6rem;
            width: max-content;
            color: $main-color;
            cursor: pointer;

            p {
                position: relative;
                max-width: inherit;

                &::after {
                    content: '';
                    position: absolute;
                    top: 50%;
                    right: -2rem;
                    transform: translateY(-50%) rotate(-90deg);
                    width: 0;
                    height: 0;
                    border-style: solid;
                    border-width: 5px 5px 0 5px;
                    border-color: $main-color transparent transparent transparent;
                    transition: all .3s ease;
                }
            }

            &__focus {
                p::after {
                    transform: translateY(-50%) rotate(0);
                }
            }
        }

        &-item {
            padding-bottom: 2rem;

            &__header {
                display: flex;
                margin-bottom: .5rem;

                span:last-of-type {
                    display: block;
                    margin-left: 1rem;
                    color: $comments-color;
                    @include fontSize(12);
                }
            }

            &__attachment {
                margin-top: 1rem;
                display: flex;
                align-items: center;

                img {
                    margin-right: 1rem;
                }
            }
        }

        &-error-message {
            margin-left: 9rem;
            padding: 1.5rem 0 .3rem 3.5rem;
            border-left: 0.3rem solid $red;
            font-size: 10px;
            color: $red;
        }

        &-bottom {

            &__input {
                display: flex;
                align-items: center;
                margin-bottom: 1rem;

                @include mobile {
                    align-items: flex-end;
                    flex-direction: column;

                    textarea {
                        margin-bottom: 1rem;
                    }
                }

                .textarea {
                    position: relative;
                    margin-right: .8rem;
                    width: 100%;

                    .attachment {
                        position: absolute;
                        top: .3rem;
                        right: 1rem;
                        cursor: pointer;
                    }

                    textarea {
                        resize: none;
                        padding-right: 4.2rem;
                    }
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

            &__models {
                display: flex;
                flex-direction: column;
                align-items: flex-end;

                p {
                    display: block;
                    margin-bottom: 1rem;
                }

                &-wrapper {
                    width: 100%;
                }

                &-list {
                    overflow: auto;
                    margin: 0;
                    padding: 0;
                    width: 100%;
                    max-height: 11rem;
                    list-style-type: none;
                    border-top: none;

                    li {
                        position: relative;
                        display: flex;
                        justify-content: space-between;
                        padding: 1rem 1rem;
                        border-bottom: 1px solid $light-grey;
                        transition: all .3s ease;

                        &:last-of-type {
                            border: none;
                        }

                        &:hover {
                            background-color: $light-grey;
                        }

                        p, .model-delete {
                            cursor: pointer;
                        }

                        p {
                            margin: 0;
                            @include fontSize(12);
                        }

                        .model-delete {
                            width: 1rem;
                            height: 1rem;
                            transition: all .3s ease;

                            &:hover {
                                transform: scale(1.2)
                            }
                        }
                    }
                }
            }
        }
    }
</style>