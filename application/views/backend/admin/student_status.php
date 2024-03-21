<style>
    #btn_export {
        position: absolute;
        top: 1em;
        right: 1em;
    }
</style>
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('student_status'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('student_status'); ?></h4>
                <button type="button" id="btn_export" class="btn btn-primary">Export</button>
                <div class="row justify-content-md-center">
                    <div class="col-xl-6">
                        <form class="form-inline" action="<?php echo site_url('admin/student_status/filter_by_date_range') ?>" method="get">
                            <div class="col-xl-10">
                                <div class="form-group">
                                    <div id="reportrange" class="form-control" data-toggle="date-picker-range" data-target-display="#selectedValue" data-cancel-class="btn-light" style="width: 100%;">
                                        <i class="mdi mdi-calendar"></i>&nbsp;
                                        <span id="selectedValue"><?php echo date("F d, Y", $timestamp_start) . " - " . date("F d, Y", $timestamp_end); ?></span> <i class="mdi mdi-menu-down"></i>
                                    </div>
                                    <input id="date_range" type="hidden" name="date_range" value="<?php echo date("d F, Y", $timestamp_start) . " - " . date("d F, Y", $timestamp_end); ?>">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <button type="submit" class="btn btn-info" id="submit-button" onclick="update_date_range();"> <?php echo get_phrase('filter'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive-sm mt-4">
                    <table id="basic-datatable" class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase('name_of_student'); ?></th>
                                <th><?php echo get_phrase('signup_date'); ?></th>
                                <th><?php echo get_phrase('course_name'); ?></th>
                                <th><?php echo get_phrase('course_starting_date'); ?></th>
                                <th><?php echo get_phrase('course_finish_date'); ?></th>
                                <th><?php echo get_phrase('date_student_last_logged'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student) : ?>
                                <tr class="gradeU">
                                    <td>
                                        <?= $student['first_name'] . ' ' . $student['last_name'] ?>
                                    </td>
                                    <td>
                                        <?= date("Y-m-d H:i:s", $student['signup_date']) ?>
                                    </td>
                                    <td>
                                        <?= $student['course_name'] ?>
                                    </td>
                                    <td>
                                        <?= $student['course_name'] != Null ? date("Y-m-d", $student['course_started']) : "NULL" ?>
                                    </td>
                                    <td>
                                        <?= $student['course_completed_date'] != NULL ? date("Y-m-d", $student['course_completed_date']) : "NULL" ?>
                                    </td>
                                    <td>
                                        <?= $student['last_logged'] != NULL ? date("Y-m-d H:i:s", $student['last_logged']) : "None" ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const siteUrl = '<?= site_url(); ?>';
    const timeZone = '<?= date_default_timezone_get(); ?>';

    function timestampToDateTime(timestamp, timeZone) {
        // Create a Date object with the provided timestamp (in milliseconds)
        var date = new Date(timestamp * 1000);

        // Options for formatting the date and time
        var options = {
            timeZone: timeZone,
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false // Use 24-hour format
        };

        // Format the date-time string based on the provided timezone
        return new Intl.DateTimeFormat('en-US', options).format(date);
    }

    function update_date_range() {
        var x = $("#selectedValue").html();
        $("#date_range").val(x);
    }

    $("#btn_export").on("click", function(e) {
        const currentUrl = window.location.href;
        const isFiltered = currentUrl.includes("date_range");

        let postData = {
            date_range: isFiltered ? $("#date_range").val() : ""
        };

        $.post(`${siteUrl}admin/export_student_status/filter_by_date_range`, postData, function(response) {
            customerList = JSON.parse(response);
            // Convert JSON data to CSV format
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Name,Signup Date,Course Name,Course Starting Date,Course Finish Date,Last Logged\r\n";

            customerList.forEach((row) => {
                let csvRow = '';
                csvRow += row.first_name + " " + row.last_name + ",";
                csvRow += timestampToDateTime(row.signup_date, timeZone).replace(',', "-") + ",";
                csvRow += row.course_name + ",";
                csvRow += (row.course_name != null ? timestampToDateTime(row.course_started, timeZone).replace(',', "-") : "NULL") + ",";
                csvRow += (row.course_completed_date != null ? timestampToDateTime(row.course_completed_date, timeZone).replace(',', "-") : "NULL") + ",";
                csvRow += (row.timestamp != null ? timestampToDateTime(row.last_logged, timeZone).replace(',', "-") : "NULL") + ",";
                csvContent += csvRow + "\r\n";
            });


            // Create a CSV file and download it
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "customers.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>