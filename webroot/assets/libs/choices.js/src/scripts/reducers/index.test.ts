import { createStore } from 'redux';
import { expect } from 'chai';
import rootReducer from '.';
import groups from './groups';
import choices from './choices';
import items from './items';
import loading from './loading';

describe('reducers/rootReducer', () => {
  const store = createStore(rootReducer);

  it('returns expected reducers', () => {
    const State = store.getState();

    expect(State.groups).to.equal(groups(undefined, {} as any));
    expect(State.choices).to.equal(choices(undefined, {} as any));
    expect(State.items).to.equal(items(undefined, {} as any));
    expect(State.loading).to.equal(loading(undefined, {} as any));
  });

  describe('CLEAR_ALL', () => {
    it('resets State', () => {
      const output = rootReducer(
        {
          items: [1, 2, 3],
          groups: [1, 2, 3],
          choices: [1, 2, 3],
        },
        {
          type: 'CLEAR_ALL',
        },
      );

      expect(output).to.eql({
        items: [],
        groups: [],
        choices: [],
        loading: false,
      });
    });
  });

  describe('RESET_TO', () => {
    it('replaces State with given State', () => {
      const output = rootReducer(
        {
          items: [1, 2, 3],
          groups: [1, 2, 3],
          choices: [1, 2, 3],
        },
        {
          type: 'RESET_TO',
          State: {},
        },
      );

      expect(output).to.eql({});
    });
  });
});
