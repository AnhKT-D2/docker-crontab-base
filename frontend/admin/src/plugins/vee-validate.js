import { extend } from "vee-validate";
import * as rules from "vee-validate/dist/rules";

export async function loadVeeValidate(locale) {
  if (locale === undefined) locale = "vi";
  const { messages } = await import(`vee-validate/dist/locale/${locale}.json`);
  Object.keys(rules).forEach(rule => {
    extend(rule, {
      ...rules[rule], // copies rule configuration
      message: messages[rule] // assign message
    });
  });
}
