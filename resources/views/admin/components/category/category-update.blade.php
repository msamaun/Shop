<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryNameUpdate">

                                <label class="form-label">Category Description *</label>
                                <input type="text" class="form-control" id="categoryDescriptionUpdate">

                                <br/>
                                <img class="w-15" id="oldLmg" src="{{asset('images/default.jpg')}}">
                                <br/>

                                <label class="form-label">Category Image *</label>
                                <input oninput="oldLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="categoryImageUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="oldImage">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function FillUpUpdateForm(id, filePath) {
        document.getElementById("updateID").value = id;
        document.getElementById("oldImage").value = filePath;
        document.getElementById("oldLmg").src = filePath;

        showLoader();
        let res = await axios.post("/category-by-id",{id:id},HeaderToken());
        hideLoader();

        document.getElementById("categoryNameUpdate").value = res.data['data']['name'];
        document.getElementById("categoryDescriptionUpdate").value = res.data['data']['description'];

    }

    async function Update() {
        let categoryName = document.getElementById('categoryNameUpdate').value
        let categoryDescription = document.getElementById('categoryDescriptionUpdate').value
        let categoryImage = document.getElementById('categoryImageUpdate').value
        let oldLmg = document.getElementById('updateID').value
        let oldImage = document.getElementById('oldImage').value

        document.getElementById('update-modal-close').click();

        let formData = new FormData();
        formData.append('name',categoryName);
        formData.append('description',categoryDescription);
        formData.append('image',categoryImage);
        formData.append('id',oldLmg);
        formData.append('file_path',oldImage);

        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                Authorization:getToken()
            }
        }

        showLoader();
        let res = await axios.post("/category-update",formData,config);
        hideLoader();
        if(res.status === 200){
            successToast("Category Updated Successfully");
            document.getElementById('update-form').reset();
            await getList();
        }else{
            errorToast("Something went wrong");
        }

    }
</script>
