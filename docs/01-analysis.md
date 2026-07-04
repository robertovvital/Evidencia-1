# Problem Analysis and Interpretation

## Context
Halcon is a construction material distributor that requires a web application to
automate its internal order-taking, tracking and delivery processes.

## Identified Actors
- **Customer**: checks their order status with customer number + invoice number.
- **Sales**: registers new orders.
- **Warehouse**: prepares orders and updates their status.
- **Purchasing**: acquires missing materials from external suppliers.
- **Route**: distributes orders and uploads photo evidence.
- **Administrator**: manages users and roles.

## Order Life Cycle
`Ordered → In process → In route → Delivered`

## Key Functional Requirements
1. Public status-lookup screen (no login) with proof photo when the status is "Delivered".
2. Administrative dashboard with role/department-based access control.
3. Order creation with: consecutive invoice number, customer data, unique customer
   number, tax data for the physical invoice, date/time, delivery address and notes.
4. Photo evidence upload restricted to the Route role.
5. Order listing and search by invoice number, customer number, date or status.
6. Logical deletion (soft delete) of orders and a screen to recover/restore deletions.

See the full detail in the use case diagram (`diagrams/use_case.png`) and in the
activity diagram of the order life cycle (`diagrams/activity_diagram.png`).
