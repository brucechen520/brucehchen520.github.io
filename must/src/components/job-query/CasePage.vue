<template>
  <!-- Modal -->
    <div class="modal fade" id="showCase" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog" role="document">
	        <div class="modal-content">
		        <div class="modal-header">
		            <h5 class="modal-title" id="exampleModalLabel">Content</h5>
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		            	<span aria-hidden="true">&times;</span>
		            </button>
		        </div>
		        <div class="modal-body">
		            <div v-if = "getJob.selected"> <!-- project -->
		            	{{ pageData }}
		            </div>

		            <div v-else> <!-- vacancy -->

		            </div>
		        </div>
		        <div class="modal-footer">
		            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		            <button type="button" class="btn btn-primary">Save changes</button>
		        </div>
	        </div>
	    </div>
    </div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';
    export default {
    	props: ['pageData'],
    	data () {
 			return {

 			}   		
    	},
    	computed: {
    		// ...mapGetters 為 ES7 寫法
	        ...mapGetters({
	            // getTodo return value 將會存在別名為 todos 的 webData 上
	            getJob: 'getJob' // 0: project, 1: vacancy
        	}),
	    }
    }
</script>

<style>

</style>