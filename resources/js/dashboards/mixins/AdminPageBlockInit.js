export default {
    mounted() {
        let self = this;
        console.log('test')
        if(this.blockData){
            for (let key in self.form){
                if(self.blockData[key]){
                    self.form[key] = self.blockData[key]
                }
            }
        }
    },
    watch: {
        form: {
            handler() {
                this.update()
            },
            deep: true
        }
    },
    methods: {
        removeItem(index){
            this.form.list.splice(index, 1)
        },
        addItem(){
            let self = this;
            let isEmpty = false;
            let form = {}

            for (let key in self.form.listItem){
                if(!self.form.listItem[key] || self.form.listItem[key] === ''){
                    isEmpty = true
                }
            }

            if(!isEmpty){
                if(!self.form.list){
                    self.form.list = []
                }

                self.form.list.push(JSON.parse(JSON.stringify(self.form.listItem)))

                for (let key in self.form.listItem){
                    self.form.listItem[key] = ''
                }
            }
            self.update()
        },
        update(){
            let self = this;
            let form = {}

            for (let key in self.form){
                form[key] = self.form[key]
            }
            this.$emit('update', form, self.index)
        }
    }
}
