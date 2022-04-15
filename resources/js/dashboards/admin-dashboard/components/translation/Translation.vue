<template>
  <div class="">
      <h1>
          Translate
      </h1>

      <div class="row langs-panel">
          <div class="col-12">
              <div class="tabs">
                  <button class="btn"
                          @click.prevent="activeTab = key"
                          :key="key"
                          v-for="(lang, key) in langs"
                          :class="{'btn-primary': activeTab === key, 'btn-secondary': activeTab !== key}"
                  >
                      {{key}}
                  </button>
                  <button class="btn btn-info" @click.prevent="synchronize">
                      synchronize
                  </button>
                  <button class="btn btn-info" @click.prevent="synchronize('clone')">
                      synchronize and clone
                  </button>
              </div>
          </div>
      </div>

      <div class="row mt-5 mb-5" v-show="activeTab === key" v-for="(lang, key) in langs">
          <template  v-for="(item, label) in lang">
              <div class="col-10 mt-2 mb-2">
                  <strong>{{label}}</strong>: <input type="text" class="form-control" v-model="lang[label]">
              </div>
              <div class="col-2 mt-2">
                  <br>
                  <button class="btn btn-danger" @click="remove(label)">Remove</button>
              </div>
          </template>
      </div>

      <div class="row mt-3 mb-5">
          <div class="col-4">
              <input type="text" class="form-control mb-3" v-model="newItemLabel">
              <input type="text" class="form-control mb-3" v-model="newItemText">

              <button class="btn btn-primary" @click="addItem">
                  Add
              </button>
              <button class="btn btn-danger">
                  Save
              </button>
          </div>
      </div>
  </div>
</template>

<script>

import messages from '../../../../locale';
const _ = require('lodash');

console.log(messages)
export default {
    name: "Translation",
    data(){
        return {
            newItemLabel: '',
            newItemText: '',
            activeTab: 'en',
            langs: messages
        }
    },
    methods: {
        remove(item){
            delete this.langs[this.activeTab][item]
        },
        addItem(){
            this.langs[this.activeTab][this.newItemLabel] = this.newItemText
            this.newItemLabel = ''
            this.newItemText = ''
        },
        synchronize(clone){
            let self = this
            let langs = []
            let langsId = []
            let keys = []
            let uniq
            for(let key in self.langs){
                langsId.push(key)
                langs.push(self.langs[key])
                keys.push(_.keys(self.langs[key]))
            }

            langs.forEach(function (item, index){
                if(index + 1 < keys.length){
                    uniq = _.union(keys[index], keys[index+1]);

                    if(clone === 'clone'){
                        _.each(self.langs[langsId[index]], function (te, ke){
                            if(ke in self.langs[langsId[index+1]]){

                            }
                            else{
                                self.langs[langsId[index+1]][ke] = te
                            }
                        })
                    }
                }
            })

            if(clone !== 'clone'){
                for(let key in self.langs){
                    uniq.forEach(function (item, index){
                        if(item in self.langs[key]){

                        }
                        else{
                            self.langs[key][item] = 'Need to be translated'
                        }
                    })
                }
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    .langs-panel{
        position: sticky;
        top: 0px;
        background-color: white;
        padding: 10px 0;
    }

    .btn{
        margin-right: 10px;
    }
</style>
