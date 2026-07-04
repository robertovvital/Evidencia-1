# Work Methodology

## Chosen Methodology: Scrum (Agile Framework)

### Justification
- **Requirements that may still shift**: the Halcon case describes a business flow
  (order life cycle) that will likely be refined while building the solution;
  Scrum allows feedback to be incorporated between sprints instead of freezing
  the scope from the start, as a waterfall model would require.
- **Verifiable incremental deliverables**: the project is already organized by
  deliverables (analysis → design → development → testing), which fits naturally
  with 1–2 week sprints that close with working product increments (e.g., first
  the public lookup module, then the dashboard, then the photo-evidence module).
- **Small team with clear roles**: Scrum works well with small teams (like a school
  team), with simple roles (Product Owner, Scrum Master, development team) that map
  directly onto the project's members.
- **Visual backlog management**: user stories derived directly from the actors and
  use cases (customer, sales, warehouse, purchasing, route, administrator) are
  easily prioritized on a backlog and a Kanban/Scrum board.

### Proposed Structure
- **Product Backlog**: user stories derived from the use cases.
- **Sprints**: 1–2 weeks each, with a deliverable goal (e.g., Sprint 1: public
  status lookup; Sprint 2: order creation and life cycle; Sprint 3: photo evidence
  upload; Sprint 4: user/role management and logical deletion).
- **Ceremonies**: sprint planning, daily stand-up, sprint review and retrospective.
- **Supporting tools**: GitHub Projects or Trello for the backlog/board, GitHub
  Issues for user stories and bugs, GitHub Flow (feature branches + pull requests)
  as the version-control workflow.

### Discarded Alternative
The **waterfall** model was discarded because it requires specifying and freezing
all requirements before coding, which adds risk if nuances of the company's real
process are discovered during development (e.g., business rules for purchasing
from external suppliers) that would be better validated incrementally with the
client.
