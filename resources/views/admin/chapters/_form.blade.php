<div class="form-group">
    <label for="title" class="col-md-2 control-label">
        Tiêu đề
    </label>
    <div class="col-md-10">
        <input class="form-control" type="text" value="{{$title}}" name="title">
    </div>
</div>
<div class="form-group">
    <label for="ordinal" class="col-md-2 control-label">
        Thứ tự
    </label>
    <div class="col-md-3">
        <input class="form-control" type="number" value="{{$ordinal}}" name="ordinal">
    </div>
</div>
<div class="form-group">
    <label for="content" class="col-md-2 control-label">
        Nội dung
    </label>
    <div class="col-md-10">
        <textarea class="form-control" name="content" rows="15" id="content">{{$content}}</textarea>
    </div>
</div>

<div class="form-group">
    <label for="published_at" class="col-md-2 control-label">
        Ngày đăng
    </label>
    <div class="col-md-3">
        <input type="datetime" name="published_at" id="published_at" value="{{$published_at}}">
    </div>
</div>