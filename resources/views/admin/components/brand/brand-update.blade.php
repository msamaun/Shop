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
                                <label class="form-label">Brand Name *</label>
                                <input type="text" class="form-control" id="brandNameUpdate">

                                <label class="form-label">Brand Description *</label>
                                <input type="text" class="form-control" id="brandDescriptionUpdate">

                                <br/>
                                <img class="w-15" id="oldLmg" src="{{asset('images/default.jpg')}}">
                                <br/>

                                <label class="form-label">Brand Image *</label>
                                <input oninput="oldLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="brandImageUpdate">

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
       let res = await axios.post("/brand-by-id",{id:id},HeaderToken());
       hideLoader();

       document.getElementById("brandNameUpdate").value = res.data['data']['name'];
       document.getElementById("brandDescriptionUpdate").value = res.data['data']['description'];

   }

   async function Update() {
       let brandName = document.getElementById('brandNameUpdate').value
       let brandDescription = document.getElementById('brandDescriptionUpdate').value
       let brandImage = document.getElementById('brandImageUpdate').value
       let oldLmg = document.getElementById('updateID').value
       let oldImage = document.getElementById('oldImage').value

       document.getElementById('update-modal-close').click();

       let formData = new FormData();
       formData.append('name',brandName);
       formData.append('description',brandDescription);
       formData.append('image',brandImage);
       formData.append('id',oldLmg);
       formData.append('file_path',oldImage);

       const config = {
           headers: {
               'content-type': 'multipart/form-data',
               Authorization:getToken()
           }
       }

       showLoader();
       let res = await axios.post("/brand-update",formData,config);
       hideLoader();
       if(res.status === 200){
           successToast("Brand Updated Successfully");
           document.getElementById('update-form').reset();
           await getList();
       }else{
           errorToast("Something went wrong");
       }

   }
</script>

