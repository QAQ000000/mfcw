# Project Agent Workflow

These rules apply to all code changes in this repository.

## Required Roles

1. The primary agent must use `gpt-5.6-sol` with `xhigh` reasoning. It owns investigation, requirements analysis, architecture, scope control, and the implementation plan.
2. The primary agent must delegate implementation to a sub-agent using `gpt-5.6-luna` with `max` reasoning. The implementation agent owns code edits and proportional tests, following the primary agent's approved design.
3. After implementation, the primary agent must delegate acceptance review to a different sub-agent using `gpt-5.6-sol` with `xhigh` reasoning. The acceptance agent must review the final diff, run relevant checks, and report correctness, regressions, side effects, and missing tests. It must not edit files during acceptance.

## Delivery Gate

- Keep design, implementation, and acceptance as separate stages. Do not use the implementation agent as the acceptance agent.
- If acceptance finds a blocking issue, return the work to the implementation stage and repeat acceptance after the fix.
- Do not commit, push, synchronize, or deploy code until the acceptance agent reports that no blocking issues remain.
- Do not silently substitute another model or reasoning level. If a required model or level is unavailable, stop and report the constraint to the user.
- The primary agent remains responsible for reconciling agent feedback and for the final delivery decision.

Read-only questions, investigation, and status reporting do not require the implementation stage unless they result in code changes.
