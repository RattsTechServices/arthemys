<div>
    <div x-data="selfieCapture()" x-init="init()" class="text-center">
        <div class="row">
            <div class="col-12">
                <button type="button" @click="startCamera" class="btn btn-primary button-selfie">Tirar Selfie</button>
            </div>
            <div class="col-12">
                <img :src="capturedImage ?? '/public/assets/arthemys/media/cam.png'" alt="Selfie Capturada"
                    class="img-fluid rounded mb-3 image-capitured border rounded-4 mt-5" style="width: 50%;"/>
            </div>
        </div>

        <!-- Modal para captura de selfie -->
        <div class="modal fade" id="selfieModal" tabindex="-1" aria-hidden="true" x-ref="modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Capture sua Selfie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <video x-ref="video" class="w-100 rounded mb-3"></video>
                            <canvas x-ref="canvas" class="d-none"></canvas>
                        </div>
                        <button type="button" @click="captureSelfie" class="btn btn-success">Capturar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para confirmação -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true" x-ref="confirmModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Selfie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img :src="capturedImage" alt="Selfie Capturada" class="img-fluid rounded mb-3" />
                        <div>
                            <button type="button" @click="confirmSelfie" class="btn btn-primary me-2">Sim</button>
                            <button type="button" @click="restart" class="btn btn-secondary">Não</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success mt-3">{!! session('message') !!}</div>
    @endif

    <script>
        function selfieCapture() {
            return {
                video: null,
                canvas: null,
                capturedImage: null,
                init() {
                    this.video = this.$refs.video;
                    this.canvas = this.$refs.canvas;
                },
                async startCamera() {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    this.video.srcObject = stream;
                    this.video.play();
                    const modal = new bootstrap.Modal(this.$refs.modal);
                    modal.show();
                },
                captureSelfie() {
                    const context = this.canvas.getContext('2d');
                    this.canvas.width = this.video.videoWidth;
                    this.canvas.height = this.video.videoHeight;
                    context.drawImage(this.video, 0, 0, this.video.videoWidth, this.video.videoHeight);
                    this.capturedImage = this.canvas.toDataURL('image/png');
                    const modal = bootstrap.Modal.getInstance(this.$refs.modal);
                    modal.hide();
                    const confirmModal = new bootstrap.Modal(this.$refs.confirmModal);
                    confirmModal.show();
                },
                confirmSelfie() {
                    @this.capture(this.capturedImage);
                    @this.confirm();
                    const confirmModal = bootstrap.Modal.getInstance(this.$refs.confirmModal);
                    confirmModal.hide();
                    $('.modal-backdrop').remove();
                },
                restart() {
                    this.capturedImage = null;
                    const confirmModal = bootstrap.Modal.getInstance(this.$refs.confirmModal);
                    confirmModal.hide();
                }
            };
        }
    </script>
</div>
