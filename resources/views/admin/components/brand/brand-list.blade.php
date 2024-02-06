<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Category</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-secondary"/>
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Brand Image</th>
                            <th>Brand Name</th>
                            <th>Brand Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getList();
    async function getList() {
        showLoader();
        let res = await axios.get("/brand-list",HeaderToken());
        hideLoader();

        let tableList = $("#tableList");
        let tableData = $("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data['data'].forEach(function (item, index) {
            let row = `<tr>
                            <td>${index + 1}</td>
                            <td><img src="${item['image']}" class="w-25" ></td>
                            <td>${item['name']}</td>
                            <td>${item['description'].substring( 0, 20)+'...'}</td>
                            <td>
                                 <button data-filepath="${item.image}" data-id="${item.id}" class="btn editBtn btn-sm btn-outline-success ">Edit</button>
                                 <button data-filepath="${item.image}" data-id="${item.id}" class="btn deleteBtn btn-sm btn-outline-danger ">Delete</button>
                            </td>
                        </tr>`;
            tableList.append(row);
        });
        $('.editBtn').on('click', async function () {
            let id = $(this).data('id');
            let filePath = $(this).data('filepath');
            await FillUpUpdateForm(id, filePath);
            $("#update-modal").modal('show');
        })

        $('.deleteBtn').on('click', function () {
            let id = $(this).data('id');
            let filePath = $(this).data('filepath');

            $("#delete-modal").modal('show');
            $("#deleteID").val(id);
            $("#deleteFilePath").val(filePath);
        })

        new DataTable('#tableData', {
            order: [[0, 'desc']],
            lengthMenu: [5, 10, 15, 20, 30]
        });
    }
</script>
