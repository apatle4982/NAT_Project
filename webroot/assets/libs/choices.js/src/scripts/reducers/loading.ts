import { SetIsLoadingAction } from '../actions/misc';
import { State } from '../interfaces/State';

export const defaultState = false;

type ActionTypes = SetIsLoadingAction | Record<string, never>;

const general = (
  State = defaultState,
  action: ActionTypes = {},
): State['loading'] => {
  switch (action.type) {
    case 'SET_IS_LOADING': {
      return action.isLoading;
    }

    default: {
      return State;
    }
  }
};

export default general;
