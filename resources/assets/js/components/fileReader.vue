<template class="columns ">
    <transition name="slide" appear>
        <div class="columns is-gapless full-height">
            <div class="column is-one-quarter">
                <div class="box content dirRepository">
                    <h2>Repertory</h2>
                    <transition name="fade" appear>
                        <nav v-if="displayDirectory">
                            <p class="has-text-centered">
                                <span @click="goRoute('-1')" v-if="urlCourant != '/'" class="icon is-large buttonRetour">
                                    <i class="fa fa-arrow-left"></i>
                                </span>
                            </p>
                                <router-link :to="item" class="nav-item is-tab" v-for="item in dirName" :key="item.id">{{ item }}</router-link>
                        </nav>
                    </transition>
                </div>
            </div>
            <div class="column">
                <div class="box content contentRepository">
                    <h2 class="inline-block">Content</h2>
                    <p class="is-pulled-right textTurquoise">{{ urlCourant }}</p>
                    <div class="is-clearfix"></div>
                    <transition name="fade" appear mode="out-in">
                        <p class="has-text-centered" v-if="displayContent">
                            <a @click="RenderFile(itemName)" class="fileContent" v-for="itemName in NameFile" id="itemName.id">
                                <span class="icon is-large">
                                    <i class="fa fa-file-code-o"></i>
                                </span>
                                <br />
                                {{ itemName }}
                            </a>
                        </p>
                        <article v-if="previewFile" class="message is-info">
                            <div class="message-header">
                                <span>{{ FileCodeName }}</span>
                                <button class="delete" @click="closePreviewFile"></button>
                            </div>
                            <div class="message-body">
                                <pre class="has-text-left">
                                    {{ previewFile }}
                                </pre>
                            </div>
                        </article>
                    </transition>
                </div>
            </div>
        </div>
    </transition>
</template>

<script type="text/babel">
    export default {
        name : 'fileReader' ,
        data : function (){
            return {
                dirName : repository.dirName ,
                NameFile : repository.NameFile ,
                urlCourant : repository.UrlCourant,
                displayDirectory : true ,
                displayContent : true ,
                previewFile : false ,
                FileCodeName : ''
            }
        },
        watch: {
            // methode appelée si r$oute change
            '$route': 'changeDir'
        } ,
        methods : {
            changeDir : function(e){

                // On fade le tout
                this.displayDirectory = false ;
                this.displayContent = false ;

                // on va envoyer un get pour afficher le fullPath contenu dans l'url et le chercher en ajax
                this.$http.get(e.fullPath).then(response => {

                    // On remet le tout
                    this.displayDirectory = true ;
                    this.displayContent = true ;

                    // get body data
                    this.dirName = response.body.dirName;
                    this.NameFile = response.body.NameFile ;
                    this.urlCourant = response.body.UrlCourant ;

                }, response => {
                    // Si il y à une erreur
                });
            } ,
            goRoute : function($step){
                // Lié à la méthode du parent
                this.$parent.goRoute($step) ;
            } ,
            RenderFile : function(fileName){

                // Le dossier + le fichier courant
                var pathToFile = this.$route.path + '/' + fileName ;

                // on va envoyer un get pour afficher le fullPath contenu dans l'url et le chercher en ajax
                this.$http.get('read' + pathToFile).then(response => {

                    this.displayContent = false ;
                    this.previewFile = response.body.content ;

                    // Mettre le nom du fichier
                    this.FileCodeName = fileName;

                }, response => {
                    // error callback
                });
            } ,
            closePreviewFile : function(){
                // On remet le content
                this.displayContent = true
                // On met à false pour bien refermer
                this.FileCodeName = false;
            }
        }
    }
</script>

<style lang="scss" rel="stylesheet/scss">

    $backgroundContent : #333;
    $turquoise:    hsl(171, 100%, 41%) !default
    $yellow:       hsl(48,  100%, 67%) !default

    body {
        background-color:#2d2d2d ;
    }

    html, body, #app, .full-height{
        height:100% ;
    }

    .box {
        border-radius:0 ;
    }

    .buttonRetour{
        color:$turquoise;
        cursor:pointer ;
    }

    .textTurquoise{
        color:$turquoise ;
    }

    .buttonRetour:hover{
        color:$yellow ;
    }

    .fileContent{
        display:inline-block ;
        padding:20px ;
    }

    .dirRepository, .contentRepository{
        height:100% ;
        background-color: $backgroundContent ;
    }

    .fade-enter-active, .fade-leave-active {
         transition: opacity .5s
     }
    .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
        opacity: 0
    }

    .slide-enter-active, .slide-leave-active {
        transition: all 1s;
    }
    .slide-enter, .slide-leave-to /* .fade-leave-active in <2.1.8 */ {
        transform: translateX(-100%);
    }

</style>