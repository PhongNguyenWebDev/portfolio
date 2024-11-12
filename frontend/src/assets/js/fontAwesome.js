import { library } from "@fortawesome/fontawesome-svg-core";
import { faHome, faUser, faEnvelope } from "@fortawesome/free-solid-svg-icons";
import {
  faFacebookF,
  faLinkedinIn,
  faGithub,
} from "@fortawesome/free-brands-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faHome, faUser, faEnvelope, faFacebookF, faLinkedinIn, faGithub);

export { FontAwesomeIcon };
