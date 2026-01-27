# TODO: Fix Overall Logic Issues in Laravel Project

## Identified Issues
1. **Payment Status Logic Inconsistency** - Participant model has conflicting payment status determination
2. **Duplicate Route Definitions** - web.php has redundant route definitions
3. **Inconsistent Payment Status Checking** - Different controllers use different methods to check payment status
4. **Missing Payment Amount Validation** - No proper validation for payment amounts against category prices
5. **Inconsistent Cache Clearing** - Cache clearing logic varies across controllers
6. **Permission Logic Misalignment** - Some controllers use direct role checks instead of middleware
7. **Missing Soft Delete Handling** - Some queries don't properly handle soft deleted records

## Tasks to Complete

### 1. Fix Payment Status Logic in Participant Model
- [x] Standardize payment status determination in `getPaymentStatusAttribute()`
- [x] Ensure consistent logic across all payment-related calculations
- [x] Update related methods to use the standardized logic

### 2. Remove Duplicate Routes
- [x] Review web.php for duplicate route definitions
- [x] Remove redundant routes while preserving functionality
- [x] Ensure route naming consistency

### 3. Standardize Payment Status Checking
- [x] Update all controllers to use consistent payment status checking
- [x] Replace direct payment queries with model accessor methods
- [x] Ensure dashboard calculations are accurate

### 4. Add Payment Amount Validation
- [x] Add validation to prevent overpayment in ParticipantController
- [x] Ensure payment amounts don't exceed remaining balance
- [x] Add proper error messages for validation failures

### 5. Standardize Cache Clearing
- [x] Implement consistent cache clearing across all controllers
- [x] Create helper method for cache invalidation
- [x] Ensure all relevant caches are cleared after data changes

### 6. Align Permission Logic
- [x] Replace direct role checks with proper middleware usage
- [x] Use the hasPermission method from Controller base class
- [x] Ensure consistent access control across all controllers

### 7. Handle Soft Deletes Properly
- [x] Update queries to properly handle soft deleted records
- [x] Ensure audit logs and statistics exclude soft deleted records
- [x] Add proper restoration logic where needed

## Testing Requirements
- [ ] Test all payment-related functionality
- [ ] Verify dashboard statistics accuracy
- [ ] Test user role permissions
- [ ] Validate form submissions and error handling
- [ ] Test cache invalidation
- [ ] Verify audit logging functionality
