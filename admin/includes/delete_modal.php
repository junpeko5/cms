<div class="modal fade" id="deleteModal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>×</span></button>
				<h4 class="modal-title">タイトル</h4>
			</div>
			<div class="modal-body">
				削除しますか？
			</div>
			<div class="modal-footer">
                <form id="form_delete" method="post" action="/cms/admin/posts.php">
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    <button id="modal_delete_btn"
                            type="submit"
                            name="delete_post_id"
                            class="btn btn-danger"
                            value="">
                        削除
                    </button>
                </form>
			</div>
		</div>
	</div>
</div>