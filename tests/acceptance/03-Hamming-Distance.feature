Feature: Hamming Distance Calculator

  Scenario Outline: Hamming distance is calculated
    Given first integer is <First Number>
    And the second integer is <Second Number>
    When the hamming distance is calculated
    Then the answer will be <Hamming Distance>

    Examples:
      | First Number | Second Number | Hamming Distance |
      | 1            | 4             | 2                |
      | 9            | 14            | 3                |
      | 4            | 8             | 2                |
      | 2            | 4             | 2                |
      | 1            | 2             | 2                |
      | 4            | 5             | 1                |
      | 7            | 10            | 3                |
