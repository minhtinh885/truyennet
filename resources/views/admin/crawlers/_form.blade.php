<div class="form-group">
    <label for="slug" class="col-md-3 control-label">Link</label>
    <div class="col-md-3">
        <input type="text" class="form-control" name="slug" value="{{$slug}}" autofocus>
    </div>
</div>

<div class="form-group">
    <label for="using" class="col-md-3 control-label">Đã sử dụng</label>
    <div class="col-md-3">
        <input type="checkbox" class="checkbox" name="using" @if($using) checked @endif>
    </div>
</div>

<div class="form-group">
    <label for="limit" class="col-md-3 control-label">Số chương</label>
    <div class="col-md-3">
        <input type="number" class="form-control" name="limit" value="{{$limit}}">
    </div>
</div>