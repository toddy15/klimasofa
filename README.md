# Klimasofa inserttags bundle for Contao 4

This bundle provides some custom inserttags for klimasofa.

Currently, these inserttags are handled:

| Inserttag          | Replacement          |
|--------------------|----------------------|
| {{CO2}}            | CO<sub>2</sub>       |
| {{current_age::*}} | Current age in years |

## Example

{{current_age::2006-07-25}} will return 14 on 16 February 2021,
and 15 on 6 November 2021.

The allowed date formats for the birthday are YYYY-MM-DD and
DD.MM.YYYY. Both the day (DD) and month (MM) may omit the
leading zero. So this is fine: {{current_age::1982-6-9}}.
