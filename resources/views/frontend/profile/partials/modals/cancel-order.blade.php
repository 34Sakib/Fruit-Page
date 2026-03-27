@if(isset($order))
<div class="modal fade" id="cancelOrder{{ $order->id }}" tabindex="-1" aria-labelledby="cancelOrderLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('orders.cancel', $order) }}" method="POST" id="cancelOrderForm{{ $order->id }}">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderLabel{{ $order->id }}">Cancel Order #{{ $order->order_number }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this order? This action cannot be undone.</p>
                    
                    <div class="mb-3">
                        <label for="reason{{ $order->id }}" class="form-label">Reason for cancellation</label>
                        <select class="form-select mb-2" name="reason" id="reason{{ $order->id }}" required>
                            <option value="">Select a reason...</option>
                            <option value="Found a better price">Found a better price</option>
                            <option value="Ordered by mistake">Ordered by mistake</option>
                            <option value="Shipping takes too long">Shipping takes too long</option>
                            <option value="other">Other (please specify)</option>
                        </select>
                        <textarea class="form-control d-none" id="other_reason{{ $order->id }}" name="other_reason" rows="2" placeholder="Please specify the reason"></textarea>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Note: If your order has already been shipped, you may need to return the items to receive a refund.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> Confirm Cancellation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle modal show event for this specific order
    document.addEventListener('DOMContentLoaded', function() {
        const modalId = 'cancelOrder{{ $order->id }}';
        const modalElement = document.getElementById(modalId);
        
        if (modalElement) {
            // Initialize modal event listeners when the modal is about to be shown
            modalElement.addEventListener('show.bs.modal', function() {
                const reasonSelect = document.getElementById('reason{{ $order->id }}');
                const otherReasonField = document.getElementById('other_reason{{ $order->id }}');
                
                if (reasonSelect && otherReasonField) {
                    // Toggle other reason field based on selection
                    reasonSelect.addEventListener('change', function() {
                        if (this.value === 'other') {
                            otherReasonField.classList.remove('d-none');
                            otherReasonField.required = true;
                        } else {
                            otherReasonField.classList.add('d-none');
                            otherReasonField.required = false;
                        }
                    });
                    
                    // Reset form when modal is hidden
                    modalElement.addEventListener('hidden.bs.modal', function() {
                        reasonSelect.value = '';
                        otherReasonField.value = '';
                        otherReasonField.classList.add('d-none');
                        otherReasonField.required = false;
                    });
                }
            });
            
            // Handle form submission
            const form = document.getElementById('cancelOrderForm{{ $order->id }}');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Processing...';
                    }
                });
            }
        }
    });
</script>
@endpush
@endif
