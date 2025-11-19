< !-- View Alumni Modal --><div class="modal fade"id="viewAlumniModal"tabindex="-1"aria-labelledby="viewAlumniModalLabel"aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"id="viewAlumniModalLabel">Detail Alumni</h5><button type="button"class="btn-close"data-bs-dismiss="modal"aria-label="Close"></button></div><div class="modal-body"><div id="alumniDetailContent"><div class="text-center"><div class="spinner-border"role="status"><span class="visually-hidden">Loading...</span></div></div></div></div></div></div></div><script>document.addEventListener('DOMContentLoaded', function() {
        // Get all view buttons
        const viewButtons=document.querySelectorAll('[data-action="view-alumni"]');
        const viewModal=document.getElementById('viewAlumniModal');
        const detailContent=document.getElementById('alumniDetailContent');

        viewButtons.forEach(button=> {
                button.addEventListener('click', function() {
                        const alumniId=this.getAttribute('data-alumni-id');

                        // Show loading state
                        detailContent.innerHTML=` <div class="text-center"> <div class="spinner-border"role="status"> <span class="visually-hidden">Loading...</span> </div> </div> `;

                        // Fetch alumni detail
                        fetch(`/api/alumni/$ {
                                alumniId
                            }

                            `) .then(response=> {
                                if ( !response.ok) throw new Error('Failed to fetch alumni detail');
                                return response.json();
                            }

                        ) .then(data=> {
                                const alumni=data.data;

                                const photoUrl=alumni.user.photo_profile ? `/storage/$ {
                                    alumni.user.photo_profile
                                }

                                ` : '/images/default-avatar.png';

                                detailContent.innerHTML=` <div class="row"> <div class="col-md-4 text-center mb-3"> <img src="${photoUrl}"alt="${alumni.user.name}"class="img-fluid rounded"style="max-height: 300px;"> </div> <div class="col-md-8"> <dl class="row"> <dt class="col-sm-4">Nama:</dt> <dd class="col-sm-8">$ {
                                    alumni.user.name
                                }

                                </dd> <dt class="col-sm-4">Email:</dt> <dd class="col-sm-8">$ {
                                    alumni.user.email
                                }

                                </dd> <dt class="col-sm-4">NIM:</dt> <dd class="col-sm-8">$ {
                                    alumni.nim
                                }

                                </dd> <dt class="col-sm-4">Jurusan:</dt> <dd class="col-sm-8">$ {
                                    alumni.major.name
                                }

                                </dd> <dt class="col-sm-4">Tahun Lulus:</dt> <dd class="col-sm-8">$ {
                                    alumni.graduation_year || 'N/A'
                                }

                                </dd> <dt class="col-sm-4">Pekerjaan:</dt> <dd class="col-sm-8">$ {
                                    alumni.career?.position || 'N/A'
                                }

                                </dd> </dl> </div> </div> `;

                                // Show modal using Bootstrap
                                if (typeof bootstrap !=='undefined'&& bootstrap.Modal) {
                                    bootstrap.Modal.getOrCreateInstance(viewModal).show();
                                }

                                else {
                                    viewModal.classList.add('show');
                                    viewModal.style.display='block';
                                    document.body.classList.add('modal-open');
                                }
                            }

                        ) .catch(error=> {
                                console.error('Error:', error);
                                detailContent.innerHTML=` <div class="alert alert-danger"> Gagal memuat detail alumni. Silakan coba lagi. </div> `;
                            }

                        );
                    }

                );
            }

        );
    }

);
</script>
