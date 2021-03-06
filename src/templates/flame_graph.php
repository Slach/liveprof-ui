<?php include __DIR__ . '/navbar.block.php'; ?>

<h2>
    Flame graph for <?= $data['snapshot_date'] ?> - <?= $data['snapshot_app'] ?> - <?= $data['snapshot_label'] ?>
    <a href="https://github.com/badoo/liveprof-ui/wiki/Web-interface#Flame-graph" class="glyphicon glyphicon-question-sign" target="_blank" data-toggle="tooltip" title="See the page documentation"></a>
</h2>

<?php if (!empty($data['error'])) { ?>
    <div class="alert alert-danger" role="alert"><?= $data['error'] ?></div>
<?php } else { ?>
    <div class="btn-group" role="group">
        <a class="btn btn-default" href="/profiler/tree-view.phtml?app=<?=  urlencode($data['snapshot_app']) ?>&label=<?= urlencode($data['snapshot_label']) ?>&method_id=0">Methods tree</a>
        <a class="btn btn-default" href="/profiler/result-diff.phtml?app=<?= urlencode($data['snapshot_app']) ?>&label=<?= urlencode($data['snapshot_label']) ?>">Diff interface</a>
        <a class="btn btn-default" href="/profiler/list-view.phtml?snapshot_id=<?= $data['snapshot_id'] ?>">Methods list</a>
        <a class="btn btn-default btn-primary" href="/profiler/result-flamegraph.phtml?app=<?= urlencode($data['snapshot_app']) ?>&label=<?= urlencode($data['snapshot_label']) ?>&snapshot_id=<?= $data['snapshot_id'] ?>">Flame graph</a>
    </div>

    <div>
        <form class="form-inline">
            <div class="form-group">
                <label for="label">param: </label>
                <select id="param" name="param">
                    <?php foreach ($data['params'] as $param) { ?>
                        <option value="<?= $param['value'] ?>" <?php if (!empty($param['selected'])) { ?>selected<?php } ?>>
                            <?= $param['label'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="diff">use diff: </label>
                <input id="diff" type="checkbox" name="diff" <?php if (!empty($data['diff'])) { ?>checked="checked"<?php } ?>>
            </div>
            <div class="form-group diff-date" <?php if (empty($data['diff'])) { ?>style="display: none;"<?php } ?>>
                <label for="exampleInputName2">Date from</label>
                <input name="date1" type="date" value="<?= $data['date1'] ?>"  class="form-control" id="exampleInputName2">
            </div>
            <div class="form-group diff-date" <?php if (empty($data['diff'])) { ?>style="display: none;"<?php } ?>>
                <label for="exampleInputEmail2">Date to</label>
                <input name="date2" type="date" value="<?= $data['date2'] ?>" class="form-control" id="exampleInputEmail2">
            </div>
            <input type="hidden" name="snapshot_id" value="<?= $data['snapshot_id'] ?>">
            <button class="btn btn-default btn-sm" id="create-ticket-link">Get flame graph</button>
        </form>
    </div>

    <table class="table table-striped">
        <?= $data['svg'] ?>
    </table>

    <div>
        * double click on a method cell to see the method's graphs in new tab
    </div>

    <script>
        $(function () {
            $('#diff').on('click', function () {
                $(".diff-date").toggle(this.checked);
            });

            $('.func_g').on('dblclick', function() {
                const title = $(this).find('title').text();
                const method_name = encodeURI(title.split(' ')[0]);

                var url = "/profiler/tree-view.phtml?app=<?=  urlencode($data['snapshot_app']) ?>";
                url += "&label=<?= urlencode($data['snapshot_label']) ?>";
                url += "&method_name=" + method_name;

                var win = window.open(url, '_blank');
                win.focus();
            });
        });
    </script>
<?php } ?>
