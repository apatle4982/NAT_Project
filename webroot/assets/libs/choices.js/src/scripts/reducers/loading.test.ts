import { expect } from 'chai';
import general, { defaultState } from './loading';

describe('reducers/loading', () => {
  it('should return same State when no action matches', () => {
    expect(general(defaultState, {} as any)).to.equal(defaultState);
  });

  describe('SET_IS_LOADING', () => {
    it('sets loading State', () => {
      const expectedState = true;

      const actualState = general(undefined, {
        type: 'SET_IS_LOADING',
        isLoading: true,
      });

      expect(expectedState).to.eql(actualState);
    });
  });
});
