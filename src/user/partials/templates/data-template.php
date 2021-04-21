<?php?>
<script type="text/html" id="tmpl-data-template">
    <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Employee Name</th>
              <th scope="col">Salary</th>
              <th scope="col">Age</th>
            </tr>
          </thead>
          <tbody>
          <# _.each(data, function(item) { #>
            <tr>
                <th scope="row">{{{item.id}}}</th>
                <td>{{{item.employee_name}}}</td>
                <td>{{{item.employee_salary}}}</td>
                <td>{{{item.employee_age}}}</td>
            </tr>
            <#}); #>
          </tbody>
    </table>
</script>