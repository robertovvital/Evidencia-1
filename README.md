# Halcon – Order Management Web System

Web application for **Halcon**, a construction material distributor, that allows
customers to check the status of their orders and lets company employees manage
the full order life cycle (Ordered → In process → In route → Delivered) from a
role-based administrative dashboard.

## Index
- [Problem Analysis](docs/01-analysis.md)
- [Work Methodology](docs/02-methodology.md)
- [UML Diagrams](docs/03-diagrams.md)
- [Database Model](docs/04-database.md)
- [Personal Reflection](docs/05-reflection.md)

## Main Modules
| Module | Description |
|---|---|
| Public lookup | Screen where the customer enters their customer number + invoice number to see the order status and, if applicable, the delivery proof photo. |
| Administrative dashboard | Role-based access (Sales, Purchasing, Warehouse, Route) to manage the order life cycle. |
| User management | A default administrator user creates new users and assigns roles/departments. |
| Order log | Listing, search (invoice, customer, date, status), editing, logical deletion and restoration of deleted orders. |

## System Roles
- **Sales**: takes and registers customer orders.
- **Purchasing**: manages the acquisition of missing materials from external suppliers.
- **Warehouse**: prepares orders, updates status to "In process" / "In route", informs Purchasing of shortages.
- **Route**: uploads photo evidence (loading and delivery) and marks the order as "Delivered".

## Proposed Tech Stack
- **Backend:** Node.js + Express (or Django/Laravel, depending on the team's stack)
- **Frontend:** React
- **Database:** MySQL / PostgreSQL (relational — see justification in `docs/04-database.md`)
- **Image storage:** File system / S3-compatible object storage
- **Version control:** Git + GitHub, Scrum agile methodology (see `docs/02-methodology.md`)

## Repository Structure
```
halcon-repo/
├── README.md
├── .gitignore
├── docs/
│   ├── 01-analysis.md
│   ├── 02-methodology.md
│   ├── 03-diagrams.md
│   ├── 04-database.md
│   ├── 05-reflection.md
│   └── diagrams/
│       ├── use_case.png
│       ├── class_diagram.png
│       ├── activity_diagram.png
│       └── er_diagram.png
├── backend/        # (to be implemented in the next deliverable)
└── frontend/       # (to be implemented in the next deliverable)
```

## How to Publish This Repository on GitHub
```bash
cd halcon-repo
git init
git add .
git commit -m "Deliverable 1: analysis, methodology and diagrams for the Halcon project"
git branch -M main
git remote add origin https://github.com/<your-username>/halcon-web.git
git push -u origin main
```
