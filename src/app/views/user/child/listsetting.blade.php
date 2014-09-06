{{-- 列表设置弹框 --}}
<div class="modal fade" id="taskListSetting_modal" tabindex="-1" role="dialog" 
  aria-labelledby="taskListSetting_modalLabel" 
  aria-hidden="true">

  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="taskListSetting_modalLabel">{{{ Lang::get('task.list_option') }}}</h4>
      </div>

      <div class="modal-body">
        <form role="form" method="post" id="taskListSetting_form" class="form-horizontal">
          <input type="hidden" id="id" name="id" value=""/>

          <div class="form-group">
            <div class="col-sm-12">
              <div class="input-group input-group-lg">
                <span class="input-group-btn">
                  <button class="btn btn-default" id="icon" data-iconset="fontawesome" data-icon="fa-heart" data-placement="bottom" role="iconpicker"></button>
                </span>
                <input type="text" class="form-control" id="name" name="name" value=""/>
              </div>
            </div>
          </div>

          <hr />
          
          <div class="row">
            <div class="col-xs-6 column">
              <div class="form-group">
                <label for="sort_by" class="col-xs-6 control-label">{{{ Lang::get('task.sort_by') }}}</label>
              </div>
              <div class="radio">
                  <label for="important">
                    <input type="radio" class="radio-normal" name="sortBy" id="important" value="important" />
                    {{{ Lang::get('task.important') }}}
                  </label>
              </div>
              <div class="radio">
                  <label for="urgent">
                    <input type="radio" class="radio-normal" name="sortBy" id="urgent" value="urgent"/>
                    {{{ Lang::get('task.urgent') }}}
              </div>
              <div class="radio">
                  <label for="sort_by">
                    <input type="radio" class="radio-normal" name="sortBy" id="date" value="date"/>
                    {{{ Lang::get('task.date') }}}
                  </label>
              </div>
              <div class="radio">
                  <label for="sort_by">
                    <input type="radio" class="radio-normal" name="sortBy" id="custom" value="custom"/>
                    {{{ Lang::get('task.custom') }}}
                  </label>
              </div>
            </div>
            <div class="col-xs-6 column">
              <div class="form-group">
                <label for="share" class="control-label">{{{ Lang::get('task.shareable') }}}</label>
              </div>
              <div class="form-group form-group-sm">
                  <input type="checkbox" name="share" id="share" />
                  <span id="shareCode" style="display: none;">
                    {{{ Lang::get('task.share_code') }}}<code></code>
                  </span>
              </div>
            </div>
          </div>
          <hr />
          <div class="form-group">
            <label for="color" class="col-sm-2 control-label">{{{ Lang::get('task.list_color') }}}</label>
            <div class="tile red" data-color="red"><i class="fa fa-check fa-lg"></i></div>
            <div class="tile orange" data-color="orange"><i class="fa fa-check fa-lg"></i></div>
            <div class="tile yellow" data-color="yellow"><i class="fa fa-check fa-lg"></i></div>
            <div class="tile green" data-color="green"><i class="fa fa-check fa-lg"></i></div>
            <div class="tile blue" data-color="blue"><i class="fa fa-check fa-lg"></i></div>
            <div class="tile indigo" data-color="indigo"><i class="fa fa-check fa-lg"></i></div>
            <div class="tile purple" data-color="purple"><i class="fa fa-check fa-lg"></i></div>
            <div class="tile black" data-color="black"><i class="fa fa-check fa-lg"></i></div>
            <div class="tile darkgray" data-color="darkgray"><i class="fa fa-check fa-lg"></i></div>
            <div class="tile gray" data-color="gray"><i class="fa fa-check fa-lg"></i></div>
            <input type="hidden" id="color" name="color"/>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" id="taskListSetting_modalDelete">{{{ Lang::get('site.delete') }}}</button>
            <button type="button" class="btn btn-default pull-left" style="display: none" id="taskListSetting_modalDeleteCancel">{{{ Lang::get('site.delete_cancel') }}}</button>
            <button type="button" class="btn btn-danger pull-left" style="display: none" id="taskListSetting_modalDeleteConfirm">{{{ Lang::get('site.delete_confirm') }}}</button>

            <button type="button" class="btn btn-default" data-dismiss="modal" id="taskListSetting_modalCancel">{{{ Lang::get('site.cancel') }}}</button>
            <button type="submit" class="btn btn-primary" id="taskListSetting_modalSubmit" >{{{ Lang::get('site.save') }}}</button>
          </div>
        </form>
      </div>

    </div>
  </div>

</div>