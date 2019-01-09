<?php include 'partials/html-head.php'; ?>
    <div class="row">
        <div class="col-sm-7">
            <h3>My courses</h3>
            <div id="totals"></div>
            <a id="showPointsBtn" onclick="printTotals()" class=""><i class="fas fa-plus"></i> See units per semester</a>
            <p>You are currently enrolled in the following courses</p>

        </div>
        <div class="col-sm-5">
            <button type="button" class="btn btn-primary btn-search-enroll btn-search-unenroll" data-toggle="modal" data-target="#unenrollModal">Unenroll</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" onclick="sort(1)">Course</th>
                        <th scope="col" onclick="sort(2)">Code</th>
                        <th scope="col" onclick="sort(3)">Units</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    
                </tbody>
            </table>
            <div class="loading">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>     
    <script>
        function loadCourses() {
            var html = $('#tableBody').html();
            var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
            var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
            $.getJSON(url,function(data){
                $.each(data, function(key,val){
                    for(i in courseArray) {
                        if(val.length >= 8 && courseArray[i] == val[6].toString().toUpperCase()) {

                            if( val[5].toLowerCase() == 'exam'){
                                        html += '<tr class="table-item-exam">';
                                    } else {
                                        html += '<tr class="table-item-course">';
                                    }
                                    html += '<td><input type="checkbox" id="enrollCheckbox' + key + '"</td>'
                                    html += '<td><a class="table-title" href="coursePage.php?courseCode=' + val[6] + '">' + val[0] + '</a><span class="table-period">' + val[5] + ' - ' + val[11] + '</span><a class="table-title-see-more" href="coursePage.php?courseCode=' + val[6] + '">Read more</a></td>';
                                    html += '<td>' + val[6] + '</td>';
                                    html += '<td>' + val[7] + '</td>';
                                    html += '<td>';
                                    if(val[12] == true){
                                        html += '<i class="fas fa-book icon-true table-icon-list" data-toggle="tooltip" data-placement="right" title="Elective"></i>';
                                    } else {
                                        html += '<i class="fas fa-book icon-false table-icon-list" data-toggle="tooltip" data-placement="right" title="Not elective"></i>';
                                    }
                                    if(val[13] == true){
                                        html += '<i class="fas fa-arrows-alt-h icon-true table-icon-list" data-toggle="tooltip" data-placement="right" title="Exchange possible"></i>';
                                    } else {
                                        html += '<i class="fas fa-arrows-alt-h icon-false table-icon-list" data-toggle="tooltip" data-placement="right" title="Exchange not possible"></i>';
                                    }
                                    if(val[14] == true){
                                        html += '<i class="fas fa-globe-africa icon-true table-icon-list" data-toggle="tooltip" data-placement="right" title="Study abroad possible"></i>';
                                    } else {
                                        html += '<i class="fas fa-globe-africa icon-false table-icon-list" data-toggle="tooltip" data-placement="right" title="Study abroad not possible"></i>';
                                    }
                                    html += '</td>';
                                    html += '</tr>';
                            // html += '<tr>';
                            // html += '<td><input type="checkbox" id="unenrollCheckbox' + key + '"</td>'
                            // html += '<td><a href="coursePage.php?courseCode=' + val[6] + '">' + val[0] + '</a></td>';
                            // html += '<td>' + val[6] + '</td>';
                            // html += '<td>' + val[7] + '</td>';
                            // html += '</tr>';
                        }
                    }
                })
                $('.loading').addClass('loading-gone');
                $('#tableBody').html(html);
                console.log(courseArray);
            })
            sort(1)
            //printTotals()
        }

        $(document).ready(loadCourses);

        var lastSortedCol = 1, lastSortedMode = 0
        function sort(column) {
            var table, rows, loop, i, x, y, doSwitch
            table = $('#tableBody')
            loop = true   

            while(loop) {
                loop = false
                rows = table.children()

                for(i = 0; i < rows.length-1; i++) {
                    doSwitch = false;
                    if(column === 1) {
                        x = rows[i].getElementsByTagName("TD")[column].firstChild
                        y = rows[i+1].getElementsByTagName("TD")[column].firstChild
                    } else {
                        x = rows[i].getElementsByTagName("TD")[column]
                        y = rows[i+1].getElementsByTagName("TD")[column]
                    }
                    if(column == lastSortedCol && lastSortedMode == 1) {
                        if(x.innerHTML.toString().toLowerCase() < y.innerHTML.toString().toLowerCase()) {
                            doSwitch = true
                            break
                        }
                    } else if(x.innerHTML.toString().toLowerCase() > y.innerHTML.toString().toLowerCase()) {
                        doSwitch = true
                        break
                    }
                }
                if(doSwitch) {
                    rows[i].parentNode.insertBefore(rows[i+1], rows[i])
                    loop = true
                }
            }
            lastSortedMode = !lastSortedMode
            if(column != lastSortedCol) {
                lastSortedMode = 1
            }
            lastSortedCol = column
            
        }
        var totalPoints = {}
        function getTotals() {
            var tableRows = document.getElementById('tableBody').children;
            for(var i = 0; i < tableRows.length; i++) {
                
                var row = tableRows[i];
                var semester = row.children[1].children[1].innerHTML.substr(9)
                var units = row.children[3].innerHTML

                if(totalPoints[semester] == undefined) {
                    totalPoints[semester] = 0
                }
                totalPoints[semester] = totalPoints[semester] + parseInt(units);
            }
            console.log(totalPoints)
        }

        function printTotals() {
            getTotals();
            Object.keys(totalPoints).forEach(function(key) {
                if (key == "18 Fall"){
                    $('#totals').html($('#totals').html() + "<span class=\"points hide\"><strong>" + key + ":</strong> " + totalPoints[key] + " Units</span>");
                } else {
                    $('#totals').html($('#totals').html() + "<span class=\"points\"><strong>" + key + ":</strong> " + totalPoints[key] + " Units</span>");
                }
            });
            $('#showPointsBtn').addClass('hide');
        }


        function enroll() {
            var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
            var tableRows = document.getElementById('tableBody').children;
            var checkedCourses = 0;
            for(var i = 0; i < tableRows.length; i++) {
                var row = tableRows[i];
                if(row.children[0].children[0].checked) {
                    for(j in courseArray) {
                        if(courseArray[j] == row.children[2].innerHTML) {
                            courseArray.splice(j,1);
                            checkedCourses++;
                        }
                    }
                }
            }
            window.sessionStorage.setItem("courseArray", JSON.stringify(courseArray));
            $('#successMessage').html("Unenrolled successfully from " + checkedCourses + " course(s)!")
            $('#successModal').modal('show');
        }
    </script>
<?php include 'partials/html-footer.php'; ?>